import sys
import time

from PyQt5.QtCore import QTimer, QThread, Qt, pyqtSignal
from PyQt5.QtWidgets import (
    QApplication, QWidget, QVBoxLayout, QHBoxLayout, QGroupBox,
    QRadioButton, QPushButton, QLabel, QButtonGroup, QDoubleSpinBox, QSpinBox,
)

try:
    import RPi.GPIO as GPIO
except ImportError:
    # Allows testing the GUI on a PC (no real GPIO)
    class _MockGPIO:
        BOARD = OUT = HIGH = 1
        LOW = 0

        def setmode(self, *a): pass
        def setwarnings(self, *a): pass
        def setup(self, *a): pass
        def output(self, pin, val):
            if pin in DEVICES.values():          # motor steps are too noisy to print
                print(f"[MOCK] pin {pin} -> {val}")
        def cleanup(self): print("[MOCK] cleanup")

    GPIO = _MockGPIO()


# ---------------- Pin configuration ----------------
DEVICES = {
    "White LED (PCB-2)": 8,
    "SW LED (PCB-2)": 18,      # 16 burned in CLA002 Rpi
    "Fluro LED (PCB-2)": 23,
    "SW Lamp (PCB-2)": 10,
    "Fan (PCB-2)": 24,
}

# ---------------- Motor configuration ----------------
# label -> (pins [in1, in2, in3, in4], steps per run)
MOTORS = {
    "Motor Y": ([32, 36, 38, 40], 4096),        # 4096 steps = 360 deg
}

# label -> clockwise?  (True = clockwise, False = anticlockwise)
DIRECTIONS = {
    "Clockwise": True,
    "anticlockwise": False,
}

MIN_DELAY_MS = 2.0   # fastest the motor can run mechanically

STEP_SEQUENCE = [[1, 0, 0, 1],
                 [1, 0, 0, 0],
                 [1, 1, 0, 0],
                 [0, 1, 0, 0],
                 [0, 1, 1, 0],
                 [0, 0, 1, 0],
                 [0, 0, 1, 1],
                 [0, 0, 0, 1]]


class MotorWorker(QThread):
    """Runs the stepper in a background thread so the GUI stays responsive."""
    finished_run = pyqtSignal()

    def __init__(self, pins, steps, delay, clockwise):
        super().__init__()
        self.pins = pins
        self.steps = steps
        self.delay = delay
        self.clockwise = clockwise
        self._abort = False

    def abort(self):
        self._abort = True

    def run(self):
        counter = 0
        for _ in range(self.steps):
            if self._abort:
                break
            for pin, value in zip(self.pins, STEP_SEQUENCE[counter]):
                GPIO.output(pin, value)
            counter = (counter - 1) % 8 if self.clockwise else (counter + 1) % 8
            time.sleep(self.delay)
        for pin in self.pins:
            GPIO.output(pin, GPIO.LOW)
        self.finished_run.emit()


def make_radio_box(title, labels, suffixes=None):
    """Returns (QGroupBox, QButtonGroup, [radio buttons]); first option checked."""
    box = QGroupBox(title)
    box_layout = QVBoxLayout(box)
    group = QButtonGroup(box)
    buttons = []
    for i, label in enumerate(labels):
        text = label + (suffixes[i] if suffixes else "")
        rb = QRadioButton(text)
        group.addButton(rb, i)
        box_layout.addWidget(rb)
        buttons.append(rb)
    buttons[0].setChecked(True)
    return box, group, buttons


class GpioControl(QWidget):
    def __init__(self):
        super().__init__()
        self.setWindowTitle("PCB-2 GPIO Control")




        GPIO.setmode(GPIO.BOARD)
        for pin in DEVICES.values():
            GPIO.setup(pin, GPIO.OUT)
            GPIO.output(pin, GPIO.LOW)
        for pins, _ in MOTORS.values():
            for pin in pins:
                GPIO.setup(pin, GPIO.OUT)
                GPIO.output(pin, GPIO.LOW)

        self.remaining = 0
        self.worker = None

        self.timer = QTimer(self)
        self.timer.setInterval(1000)
        self.timer.timeout.connect(self._tick)

        self._build_ui()

    # ---------------- UI ----------------
    def _build_ui(self):
        layout = QVBoxLayout(self)

        # ----- Devices -----
        dev_box, self.dev_group, self.dev_radios = make_radio_box(
            "Select device", list(DEVICES.keys()),
            [f"  (pin {p})" for p in DEVICES.values()])
        layout.addWidget(dev_box)

        row = QHBoxLayout()
        row.addWidget(QLabel("Timeout:"))
        self.timeout_spin = QSpinBox()
        self.timeout_spin.setRange(1, 3600)
        self.timeout_spin.setValue(2)
        self.timeout_spin.setSuffix(" seconds")
        row.addWidget(self.timeout_spin, 1)
        layout.addLayout(row)

        self.start_btn = QPushButton("Start")
        self.start_btn.clicked.connect(self.start)
        layout.addWidget(self.start_btn)

        # ----- Motor -----
        motor_box, self.motor_group, self.motor_radios = make_radio_box(
            "Select motor", list(MOTORS.keys()),
            [f"  (pins {', '.join(map(str, p))})" for p, _ in MOTORS.values()])
        layout.addWidget(motor_box)

        speed_box = QGroupBox("Speed")
        speed_row = QHBoxLayout(speed_box)
        speed_row.addWidget(QLabel("Delay:"))
        self.manual_spin = QDoubleSpinBox()
        self.manual_spin.setRange(MIN_DELAY_MS, 100.0)   # below 2 ms the motor stalls
        self.manual_spin.setDecimals(1)
        self.manual_spin.setSingleStep(0.5)
        self.manual_spin.setValue(MIN_DELAY_MS)
        self.manual_spin.setSuffix(" ms/step")
        speed_row.addWidget(self.manual_spin, 1)
        layout.addWidget(speed_box)

        dir_box, self.dir_group, self.dir_radios = make_radio_box(
            "Direction", list(DIRECTIONS.keys()))
        layout.addWidget(dir_box)

        self.motor_btn = QPushButton("Run Motor")
        self.motor_btn.clicked.connect(self.run_motor)
        layout.addWidget(self.motor_btn)

        # ----- Status -----
        self.status = QLabel("Idle")
        self.status.setAlignment(Qt.AlignCenter)
        layout.addWidget(self.status)

        # everything that gets locked while something is running
        self.lockable = (self.dev_radios + self.motor_radios + self.dir_radios
                         + [self.timeout_spin, self.manual_spin,
                            self.start_btn, self.motor_btn])

    def set_busy(self, busy):
        for w in self.lockable:
            w.setEnabled(not busy)

    # ---------------- Device logic ----------------
    def _selected_device(self):
        idx = self.dev_group.checkedId()
        return list(DEVICES.values())[idx], list(DEVICES.keys())[idx]

    def start(self):
        self.stop()  # make sure everything is off first
        pin, name = self._selected_device()
        seconds = self.timeout_spin.value()

        GPIO.output(pin, GPIO.HIGH)
        self.remaining = seconds
        self.set_busy(True)

        self.status.setText(f"{name} ON - {self.remaining}s left")
        self.timer.start()

    def stop(self):
        """Turn all devices off (timeout, before a new start, and on close)."""
        self.timer.stop()
        for pin in DEVICES.values():
            GPIO.output(pin, GPIO.LOW)
        self.set_busy(False)
        self.status.setText("Idle")

    def _tick(self):
        self.remaining -= 1
        if self.remaining <= 0:
            self.stop()
            self.status.setText("Timeout reached - OFF")
        else:
            _, name = self._selected_device()
            self.status.setText(f"{name} ON - {self.remaining}s left")

    # ---------------- Motor logic ----------------
    def run_motor(self):
        motor_name = list(MOTORS.keys())[self.motor_group.checkedId()]
        pins, steps = MOTORS[motor_name]
        delay = self.manual_spin.value() / 1000.0
        speed_name = f"{self.manual_spin.value():g} ms/step"
        dir_name = list(DIRECTIONS.keys())[self.dir_group.checkedId()]

        self.worker = MotorWorker(pins, steps, delay, DIRECTIONS[dir_name])
        self.worker.finished_run.connect(self._motor_done)
        self.set_busy(True)
        self.status.setText(f"{motor_name} running - {speed_name}, {dir_name}")
        self.worker.start()

    def _motor_done(self):
        self.set_busy(False)
        self.status.setText("Motor finished")

    # ---------------- Close ----------------
    def closeEvent(self, event):
        if self.worker is not None and self.worker.isRunning():
            self.worker.abort()
            self.worker.wait()
        self.stop()
        GPIO.cleanup()
        event.accept()


if __name__ == "__main__":
    app = QApplication(sys.argv)
    win = GpioControl()
    win.show()
    sys.exit(app.exec_())