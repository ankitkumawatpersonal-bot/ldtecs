import shutil
import sys
import time

from PyQt5.QtCore import (QTimer, QThread, Qt, QProcess, QProcessEnvironment,
                          QRectF, QSize, pyqtSignal)
from PyQt5.QtGui import QColor, QFont, QPainter, QPen
from PyQt5.QtWidgets import (
    QApplication, QWidget, QVBoxLayout, QHBoxLayout, QGroupBox,
    QRadioButton, QPushButton, QLabel, QButtonGroup, QDoubleSpinBox, QSpinBox,
    QAbstractButton,
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

# ---------------- Camera configuration ----------------
# rpicam-* is the new name of libcamera-* (Raspberry Pi OS Bookworm and later);
# the old names still work as aliases, so both are offered.
CAMERA_COMMANDS = ["rpicam-still", "libcamera-still"]


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


class CommandSwitch(QAbstractButton):
    """Two-position switch (neutral grey, no colour) that picks
    between the two camera commands. Knob left = first command, right = second."""

    def __init__(self, left, right, parent=None):
        super().__init__(parent)
        self.names = (left, right)
        self.setCheckable(True)
        self.setCursor(Qt.PointingHandCursor)
        self.setFixedSize(250, 46)

    def sizeHint(self):
        return QSize(250, 46)

    def command(self):
        return self.names[1] if self.isChecked() else self.names[0]

    def paintEvent(self, _event):
        p = QPainter(self)
        p.setRenderHint(QPainter.Antialiasing)
        w, h = self.width(), self.height()
        on = self.isEnabled()
        kw = w // 2 - 6                     # knob width
        right = self.isChecked()

        # track
        track = QRectF(1, 1, w - 2, h - 2)
        p.setPen(QPen(QColor("#8a8a8a") if on else QColor("#bdbdbd"), 2))
        p.setBrush(QColor("#d4d4d4") if on else QColor("#e6e6e6"))
        p.drawRoundedRect(track, h / 2, h / 2)

        font = QFont(self.font())
        font.setBold(True)
        font.setPixelSize(13)
        p.setFont(font)

        # name of the command that is NOT selected, dimmed on the track
        other_rect = QRectF(8, 0, w - kw - 16, h) if right else QRectF(kw + 8, 0, w - kw - 16, h)
        p.setPen(QColor("#7a7a7a"))
        p.drawText(other_rect, Qt.AlignCenter, self.names[0] if right else self.names[1])

        # knob
        kx = w - 5 - kw if right else 5
        knob = QRectF(kx, 5, kw, h - 10)
        p.setPen(QPen(QColor("#9a9a9a"), 1.5))
        p.setBrush(QColor("#ffffff") if on else QColor("#f0f0f0"))
        p.drawRoundedRect(knob, (h - 10) / 2, (h - 10) / 2)

        # selected command text
        p.setPen(QColor("#202020") if on else QColor("#8a8a8a"))
        p.drawText(knob, Qt.AlignCenter, self.command())


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
        self.cam_proc = None          # QProcess running rpicam-/libcamera-*
        self.cam_stopped_by_user = False
        self.motor_stopped_by_user = False

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

        dev_btn_row = QHBoxLayout()
        self.start_btn = QPushButton("Start")
        self.start_btn.clicked.connect(self.start)
        dev_btn_row.addWidget(self.start_btn)

        self.dev_stop_btn = QPushButton("Stop")
        self.dev_stop_btn.setEnabled(False)
        self.dev_stop_btn.clicked.connect(self.stop_device)
        dev_btn_row.addWidget(self.dev_stop_btn)
        layout.addLayout(dev_btn_row)

        # ----- Motor -----
        motor_box, self.motor_group, self.motor_radios = make_radio_box(
            "Select motor", list(MOTORS.keys()),
            [f"  (pins {', '.join(map(str, p))})" for p, _ in MOTORS.values()])
        layout.addWidget(motor_box)

        speed_box = QGroupBox("Speed")
        speed_row = QHBoxLayout(speed_box)
        self.manual_spin = QDoubleSpinBox()
        self.manual_spin.setRange(MIN_DELAY_MS, 100.0)   # below 2 ms the motor stalls
        self.manual_spin.setDecimals(1)
        self.manual_spin.setSingleStep(0.5)
        self.manual_spin.setValue(MIN_DELAY_MS)
        self.manual_spin.setSuffix(" ms/step")
        self.manual_spin.setToolTip("Lower number = faster motor")
        speed_row.addWidget(self.manual_spin, 1)
        layout.addWidget(speed_box)

        dir_box, self.dir_group, self.dir_radios = make_radio_box(
            "Direction", list(DIRECTIONS.keys()))
        layout.addWidget(dir_box)

        motor_btn_row = QHBoxLayout()
        self.motor_btn = QPushButton("Run Motor")
        self.motor_btn.clicked.connect(self.run_motor)
        motor_btn_row.addWidget(self.motor_btn)

        self.motor_stop_btn = QPushButton("Stop")
        self.motor_stop_btn.setEnabled(False)
        self.motor_stop_btn.clicked.connect(self.stop_motor)
        motor_btn_row.addWidget(self.motor_stop_btn)
        layout.addLayout(motor_btn_row)

        # ----- Camera -----
        cam_box = QGroupBox("Camera")
        cam_layout = QVBoxLayout(cam_box)

        cmd_row = QHBoxLayout()
        cmd_row.addWidget(QLabel("Command:"))
        self.cam_cmd_switch = CommandSwitch(*CAMERA_COMMANDS)
        # start on libcamera-still only if rpicam-still is missing but libcamera-still exists
        if not shutil.which(CAMERA_COMMANDS[0]) and shutil.which(CAMERA_COMMANDS[1]):
            self.cam_cmd_switch.setChecked(True)
        cmd_row.addStretch(1)
        cmd_row.addWidget(self.cam_cmd_switch)
        cam_layout.addLayout(cmd_row)

        manual_row = QHBoxLayout()
        manual_row.addWidget(QLabel("Time:"))
        self.cam_manual_spin = QDoubleSpinBox()
        self.cam_manual_spin.setRange(0.5, 3600.0)
        self.cam_manual_spin.setDecimals(1)
        self.cam_manual_spin.setSingleStep(0.5)
        self.cam_manual_spin.setValue(5.0)
        self.cam_manual_spin.setSuffix(" seconds")
        manual_row.addWidget(self.cam_manual_spin, 1)
        cam_layout.addLayout(manual_row)

        btn_row = QHBoxLayout()
        self.cam_start_btn = QPushButton("Start Camera")
        self.cam_start_btn.clicked.connect(self.start_camera)
        btn_row.addWidget(self.cam_start_btn)

        self.cam_stop_btn = QPushButton("Stop")
        self.cam_stop_btn.setEnabled(False)
        self.cam_stop_btn.clicked.connect(self.stop_camera)
        btn_row.addWidget(self.cam_stop_btn)
        cam_layout.addLayout(btn_row)

        layout.addWidget(cam_box)

        # ----- Stop everything -----
        self.all_stop_btn = QPushButton("STOP ALL")
        self.all_stop_btn.setMinimumHeight(40)
        self.all_stop_btn.setStyleSheet(
            "background-color: #d32f2f; color: white; font-weight: bold;")
        self.all_stop_btn.clicked.connect(self.stop_all)
        layout.addWidget(self.all_stop_btn)

        # ----- Status -----
        self.status = QLabel(self.cam_cmd_switch.command())
        self.status.setAlignment(Qt.AlignCenter)
        layout.addWidget(self.status)

        # clicking the switch shows only the selected command in the status line
        self.cam_cmd_switch.toggled.connect(
            lambda _checked: self.status.setText(self.cam_cmd_switch.command()))

        # everything that gets locked while a device / the motor is running
        self.lockable = (self.dev_radios + self.motor_radios + self.dir_radios
                         + [self.timeout_spin, self.manual_spin,
                            self.start_btn, self.motor_btn])

        # camera widgets locked while the camera is running
        self.cam_lockable = [self.cam_cmd_switch, self.cam_manual_spin,
                             self.cam_start_btn]

    def set_busy(self, busy, kind=None):
        """kind = "device" or "motor": which Stop button should be usable."""
        for w in self.lockable:
            w.setEnabled(not busy)
        self.dev_stop_btn.setEnabled(busy and kind == "device")
        self.motor_stop_btn.setEnabled(busy and kind == "motor")

    def set_camera_busy(self, busy):
        for w in self.cam_lockable:
            w.setEnabled(not busy)
        self.cam_stop_btn.setEnabled(busy)

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
        self.set_busy(True, "device")

        self.status.setText(f"{name} ON - {self.remaining}s left")
        self.timer.start()

    def stop(self):
        """Turn all devices off (timeout, before a new start, and on close)."""
        self.timer.stop()
        for pin in DEVICES.values():
            GPIO.output(pin, GPIO.LOW)
        self.set_busy(False)
        self.status.setText(self.cam_cmd_switch.command())

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
        self.motor_stopped_by_user = False
        self.set_busy(True, "motor")
        self.status.setText(f"{motor_name} running - {speed_name}, {dir_name}")
        self.worker.start()

    def _motor_done(self):
        self.set_busy(False)
        self.status.setText("Motor stopped" if self.motor_stopped_by_user
                            else "Motor finished")

    # ---------------- Stop buttons ----------------
    def stop_device(self):
        """Stop button next to Start: switch the selected device (all pins) OFF."""
        self.stop()
        self.status.setText("Device stopped - OFF")

    def stop_motor(self):
        """Stop button next to Run Motor: abort the run after the current step."""
        if self.worker is not None and self.worker.isRunning():
            self.motor_stopped_by_user = True
            self.worker.abort()          # _motor_done() runs when the thread ends

    def stop_all(self):
        """Emergency stop: devices OFF, motor stopped, camera stopped."""
        self.stop_camera()
        if self.worker is not None and self.worker.isRunning():
            try:
                self.worker.finished_run.disconnect(self._motor_done)
            except TypeError:
                pass
            self.worker.abort()
            self.worker.wait()
        self.stop()                      # all device pins LOW, unlock the UI
        self.status.setText("ALL STOPPED")

    # ---------------- Camera logic ----------------
    def _launch_camera(self, program, args, message):
        """Start a camera program without blocking the GUI."""
        self.cam_stopped_by_user = False
        self.cam_proc = QProcess(self)
        env = QProcessEnvironment.systemEnvironment()
        if not env.contains("DISPLAY") and not env.contains("WAYLAND_DISPLAY"):
            env.insert("DISPLAY", ":0")          # e.g. app started with sudo / from a service
        self.cam_proc.setProcessEnvironment(env)
        self.cam_proc.setProcessChannelMode(QProcess.MergedChannels)
        self.cam_proc.finished.connect(self._camera_finished)
        self.cam_proc.errorOccurred.connect(self._camera_error)
        self.set_camera_busy(True)
        self.status.setText(message)
        print("[CAMERA]", program, " ".join(args))
        self.cam_proc.start(program, args)

    def start_camera(self):
        """Run the camera preview for the selected time (nothing is saved)."""
        program = self.cam_cmd_switch.command()
        ms = int(self.cam_manual_spin.value() * 1000)

        if shutil.which(program) is None:
            other = [c for c in CAMERA_COMMANDS if c != program][0]
            hint = f" - switch to {other}" if shutil.which(other) else ""
            self.status.setText(f"{program} is not installed on this Pi{hint}")
            return

        self._launch_camera(program, ["-t", str(ms), "-o", "/dev/null"],
                            f"Camera: running for {ms / 1000:g}s...")

    def stop_camera(self):
        if self.cam_proc is not None and \
                self.cam_proc.state() != QProcess.NotRunning:
            self.cam_stopped_by_user = True
            self.cam_proc.terminate()

    def _camera_finished(self, exit_code, _exit_status):
        self.set_camera_busy(False)
        if self.cam_stopped_by_user:
            self.status.setText(self.cam_cmd_switch.command())
        elif exit_code != 0:
            err = bytes(self.cam_proc.readAll()).decode(errors="replace")
            print(err)
            last = err.strip().splitlines()[-1] if err.strip() else f"exit code {exit_code}"
            self.status.setText(f"Camera error: {last}")
        else:
            print(bytes(self.cam_proc.readAll()).decode(errors="replace"))
            self.status.setText(self.cam_cmd_switch.command())
        self.cam_proc = None

    def _camera_error(self, error):
        # Only FailedToStart needs handling here; other errors end up in finished()
        if error == QProcess.FailedToStart:
            self.set_camera_busy(False)
            self.status.setText("Camera command not found - is it installed?")

    # ---------------- Close ----------------
    def closeEvent(self, event):
        if self.worker is not None and self.worker.isRunning():
            self.worker.abort()
            self.worker.wait()
        if self.cam_proc is not None and \
                self.cam_proc.state() != QProcess.NotRunning:
            self.cam_proc.kill()
            self.cam_proc.waitForFinished(2000)
        self.stop()
        GPIO.cleanup()
        event.accept()


if __name__ == "__main__":
    app = QApplication(sys.argv)
    win = GpioControl()
    win.show()
    sys.exit(app.exec_())