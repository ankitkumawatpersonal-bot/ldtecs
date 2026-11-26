from flask import Flask, render_template, Response, jsonify, send_file, request
import cv2
import numpy as np
import time
import os
import imutils
import zipfile
import io
import re
import subprocess
import threading
import tempfile
import shutil
import gc

try:
    from picamera2 import Picamera2
    PICAMERA2_AVAILABLE = True
except ImportError:
    PICAMERA2_AVAILABLE = False

try:
    import RPi.GPIO as GPIO
    GPIO_AVAILABLE = True
except ImportError:
    GPIO_AVAILABLE = False
    print("WARNING: RPi.GPIO not available. Running in simulation mode.")

app = Flask(__name__)

# ==========================================
# GPIO PIN CONFIGURATION
# ==========================================
WHITE_LED  = 8    # White Light
SW_LED     = 16   # SW Led (simulant)
FLURO_LED  = 23   # Fluorescence Led
SW_LAMP    = 10   # SW Lamp (short/long phosphorescence)
FAN        = 24   # FAN

SIGNAL_ON  = True
SIGNAL_OFF = not SIGNAL_ON

# ==========================================
# GPIO SETUP
# ==========================================
def setup_gpio():
    if not GPIO_AVAILABLE:
        print("GPIO not available - skipping setup")
        return
    GPIO.setmode(GPIO.BOARD)
    for pin in [WHITE_LED, SW_LED, FLURO_LED, SW_LAMP, FAN]:
        GPIO.setup(pin, GPIO.OUT)
        GPIO.output(pin, SIGNAL_OFF)
    print("GPIO setup complete - all lights OFF")

def cleanup_gpio():
    if GPIO_AVAILABLE:
        GPIO.cleanup()

setup_gpio()

# ==========================================
# SIMPLE SCAN FLAG (single device only, no lock)
# ==========================================
scan_in_progress = False
scan_lock = threading.Lock()

scan_progress = {'percent': 0, 'step': '', 'status': 'idle'}

def update_scan_progress(percent, step_name):
    global scan_progress
    scan_progress = {'percent': percent, 'step': step_name, 'status': 'running'}
    print(f"Progress: {percent}% - {step_name}")

# ==========================================
# TEMPORARY STORAGE - NO PERMANENT SAVES
# ==========================================
current_scan_folder = None   # Temporary folder for current scan only

def cleanup_old_scan():
    """Delete old scan temp folder to free memory"""
    global current_scan_folder
    if current_scan_folder and os.path.exists(current_scan_folder):
        try:
            shutil.rmtree(current_scan_folder)
            print(f"CLEANED old scan: {current_scan_folder}")
        except Exception as e:
            print(f"Cleanup error: {e}")
    current_scan_folder = None

# ==========================================
# SETTINGS
# ==========================================
USE_PICAMERA2 = True
USE_FAKE      = False
# USE_PICAMERA2 = False
# USE_FAKE      = True

# ==========================================
# FOLDERS
# ==========================================
REF_IMAGE_FOLDER  = os.path.join('static', 'reference')
CONFIG_FOLDER     = os.path.join('static', 'config')
os.makedirs(REF_IMAGE_FOLDER, exist_ok=True)
os.makedirs(CONFIG_FOLDER,    exist_ok=True)

INFO_FILE = os.path.join(CONFIG_FOLDER, 'info.txt')

# ==========================================
# HARDCODED COLORS (BGR)
# ==========================================
COLORS = {
    'hpht':     (255, 0,   0),
    'cvd':      (255, 0,   255),
    'cvd_t':    (255, 255, 0),
    'simulant': (0,   255, 255),
    'rft':      (0,   0,   255),
    'natural':  (0,   255, 0),
}

# ==========================================
# CONFIG FILE DEFINITIONS
# ==========================================
# Order matters for read/write - must match config file line order
PARAMETER_INT   = ["width", "height", "rotation", "shutter", "analoggain",
                   "gain", "ev", "quality", "hflip", "vflip"]

PARAMETER_FLOAT = ["brightness", "contrast", "saturation", "sharpness", "framerate"]

PARAMETER_TUPLE = ["awbgains", "roi", "preview"]

PARAMETER_STR   = ["awb", "denoise", "metering", "exposure", "constrain"]

# NEW: awbenable is a toggle (0/1) - treated as int but comes after str section
# We handle it specially

CONFIG_FILES = {
    'config':  'config.txt',
    'config1': 'config1.txt',
    'config2': 'config2.txt',
    'config3': 'config3.txt',
    'config4': 'config4.txt',
    'config5': 'config5.txt',
    'config6': 'config6.txt',
}

MODE_TO_CONFIG = {
    'preview':              'config',
    'whitelight':           'config1',
    'fluorescence':         'config2',
    'shortphosphorescence': 'config3',
    'longphosphorescence':  'config4',
    'superimage':           'config5',
    'simulant':             'config6',
}

DEFAULT_CONFIG = {
    'width': 1920, 'height': 1080, 'rotation': 0,
    'shutter': 10000, 'analoggain': 1, 'gain': 1, 'ev': 0, 'quality': 100,
    'hflip': 1, 'vflip': 1,
    'brightness': 0.0, 'contrast': 1.0, 'saturation': 1.0, 'sharpness': 1.0, 'framerate': 30.0,
    'awbgains': [0.0, 0.0], 'roi': [0.0, 0.0, 1.0, 1.0], 'preview': [8, 95, 1200, 910],
    'awb': 'custom', 'denoise': 'auto', 'metering': 'average', 'exposure': 'normal',
    'constrain': 'normal', 'awbenable': 0,
}

# ==========================================
# CONFIG READ / WRITE
# ==========================================
def read_config_file(config_key):
    filepath = os.path.join(CONFIG_FOLDER, CONFIG_FILES.get(config_key, 'config.txt'))
    result = dict(DEFAULT_CONFIG)

    if not os.path.exists(filepath):
        print(f"Config file not found: {filepath}, using defaults")
        return result

    try:
        with open(filepath, 'r') as f:
            lines = [l.strip() for l in f if l.strip() and '=' in l and not l.startswith('#')]

        for i, line in enumerate(lines):
            key, value = [x.strip() for x in line.split('=', 1)]

            if key in PARAMETER_INT:
                try:
                    result[key] = int(float(value))
                except ValueError:
                    result[key] = int(float(value)) if value else 0
            elif key in PARAMETER_FLOAT:
                try:
                    result[key] = float(value)
                except ValueError:
                    result[key] = 0.0
            elif key in PARAMETER_TUPLE:
                result[key] = [float(v.strip()) for v in value.split(',')]
            elif key in PARAMETER_STR:
                result[key] = value
            elif key == 'awbenable':
                result[key] = int(float(value)) if value else 0
            elif key == 'constrain':
                result[key] = value
            else:
                # Unknown key - try to parse intelligently
                try:
                    result[key] = int(float(value))
                except ValueError:
                    try:
                        result[key] = float(value)
                    except ValueError:
                        result[key] = value

        print(f"[CONFIG READ] {config_key}: shutter={result.get('shutter')}, "
              f"analoggain={result.get('analoggain')}, gain={result.get('gain')}, "
              f"hflip={result.get('hflip')}, vflip={result.get('vflip')}, "
              f"awbgains={result.get('awbgains')}, awbenable={result.get('awbenable')}, "
              f"constrain={result.get('constrain')}")
    except Exception as e:
        print(f"Error reading config {filepath}: {e}")

    return result


def write_config_file(config_key, config_dict):
    filepath = os.path.join(CONFIG_FOLDER, CONFIG_FILES.get(config_key, 'config.txt'))

    def to_str(val):
        if isinstance(val, list):
            return ','.join(str(v) for v in val)
        return str(val)

    # Write in proper order + extra fields
    order = (PARAMETER_INT + PARAMETER_FLOAT + PARAMETER_TUPLE + PARAMETER_STR + ['awbenable'])

    with open(filepath, 'w') as f:
        for key in order:
            if key in config_dict:
                val = config_dict[key]
                f.write(f"{key}={to_str(val)}\n")
        # Write any extra keys not in order
        for key, val in config_dict.items():
            if key not in order:
                f.write(f"{key}={to_str(val)}\n")

    print(f"[CONFIG WRITE] {config_key} saved to {filepath}")


# ==========================================
# INFO.TXT READ / WRITE
# ==========================================
def parse_info_file():
    info = {}
    if os.path.exists(INFO_FILE):
        with open(INFO_FILE, 'r') as f:
            for line in f:
                line = line.strip()
                if line and '=' in line and not line.startswith('#'):
                    key, value = line.split('=', 1)
                    info[key.strip()] = value.strip()
    return info

def write_info_file(info_dict):
    with open(INFO_FILE, 'w') as f:
        for key, value in info_dict.items():
            f.write(f"{key}={value}\n")

def get_simulant_enabled():
    return parse_info_file().get('simulant', '0') == '1'

# ==========================================
# CAMERA SETUP - MODULE LEVEL (NO RECONFIGURE DURING SCAN)
# ==========================================
picam2 = None
current_camera_size = (1920, 1080)

def _get_transform_from_config(config_key='config'):
    """Get libcamera Transform from config hflip/vflip values"""
    try:
        from libcamera import Transform
        cfg = read_config_file(config_key)
        hflip = bool(int(cfg.get('hflip', 1)))
        vflip = bool(int(cfg.get('vflip', 1)))
        print(f"[TRANSFORM] hflip={hflip}, vflip={vflip}")
        return Transform(hflip=hflip, vflip=vflip)
    except Exception as e:
        print(f"[TRANSFORM] Error: {e} — using default (hflip=True, vflip=True)")
        try:
            from libcamera import Transform
            return Transform(hflip=True, vflip=True)
        except Exception:
            return None

def _init_camera_module_level():
    """Initialize camera once at module level - NEVER reconfigure during scan"""
    global picam2, current_camera_size

    if not (USE_PICAMERA2 and PICAMERA2_AVAILABLE):
        print("Picamera2 not available - skipping camera init")
        return False

    try:
        cfg = read_config_file('config')
        width = int(cfg.get('width', 1920))
        height = int(cfg.get('height', 1080))
        current_camera_size = (width, height)

        transform = _get_transform_from_config('config')

        picam2 = Picamera2()
        cam_kwargs = {"main": {"size": current_camera_size}}
        if transform is not None:
            cam_kwargs["transform"] = transform

        camera_config = picam2.create_preview_configuration(**cam_kwargs)
        picam2.configure(camera_config)
        picam2.start()
        time.sleep(1)

        print(f"[CAMERA INIT] Picamera2 started with size={current_camera_size}")
        return True

    except Exception as e:
        print(f"[CAMERA INIT] Error: {e}")
        import traceback
        traceback.print_exc()
        return False

def restart_camera_with_config():
    """Restart camera with new config - ONLY called from setting save, NOT during scan"""
    global picam2, current_camera_size

    if not (USE_PICAMERA2 and PICAMERA2_AVAILABLE):
        print("Picamera2 not available - skipping camera restart")
        return False

    try:
        cfg = read_config_file('config')
        width = int(cfg.get('width', 1920))
        height = int(cfg.get('height', 1080))
        current_camera_size = (width, height)

        transform = _get_transform_from_config('config')

        if picam2 is not None:
            try:
                picam2.stop()
                picam2.close()
            except Exception as e:
                print(f"[CAMERA RESTART] Stop error: {e}")
            picam2 = None

        picam2 = Picamera2()
        cam_kwargs = {"main": {"size": current_camera_size}}
        if transform is not None:
            cam_kwargs["transform"] = transform

        camera_config = picam2.create_preview_configuration(**cam_kwargs)
        picam2.configure(camera_config)
        picam2.start()
        time.sleep(0.5)

        apply_mode_config('preview')
        print(f"[CAMERA RESTART] Success! size={current_camera_size}")
        return True

    except Exception as e:
        print(f"[CAMERA RESTART] Error: {e}")
        import traceback
        traceback.print_exc()
        return False

# Initialize camera on module import (startup)
if USE_FAKE:
    pass
elif USE_PICAMERA2 and PICAMERA2_AVAILABLE:
    _init_camera_module_level()
else:
    camera = cv2.VideoCapture(0)
    camera.set(cv2.CAP_PROP_FRAME_WIDTH, 640)
    camera.set(cv2.CAP_PROP_FRAME_HEIGHT, 480)

# ==========================================
# FRAME CAPTURE
# ==========================================
def get_frame():
    if USE_FAKE:
        frame = np.zeros((480, 640, 3), dtype=np.uint8)
        t = time.time()
        x = int(320 + 200 * np.sin(t * 2))
        y = int(240 + 150 * np.cos(t * 3))
        cv2.circle(frame, (x, y), 30, (0, 255, 0), -1)
        cv2.putText(frame, "FAKE CAMERA", (50, 50),
                    cv2.FONT_HERSHEY_SIMPLEX, 1, (0, 255, 255), 2)
        return frame
    elif USE_PICAMERA2 and PICAMERA2_AVAILABLE and picam2 is not None:
        frame = picam2.capture_array()
        frame = cv2.cvtColor(frame, cv2.COLOR_RGB2BGR)
        return frame
    else:
        success, frame = camera.read()
        if not success:
            return np.zeros((480, 640, 3), dtype=np.uint8)
        return frame

# ==========================================
# APPLY CONFIG TO CAMERA - CONTROLS ONLY, NO RECONFIGURE
# ==========================================
def apply_mode_config(mode_name):
    """Apply config settings to the live camera - ONLY controls, NEVER reconfigure during scan"""
    if not (USE_PICAMERA2 and PICAMERA2_AVAILABLE and picam2 is not None):
        print(f"Picamera2 not available — skipping config for {mode_name}")
        return False

    config_key = MODE_TO_CONFIG.get(mode_name, 'config')
    cfg = read_config_file(config_key)

    try:
        controls = {}

        # 1. Exposure Time (shutter)
        if 'shutter' in cfg:
            shutter_val = int(cfg['shutter'])
            if shutter_val > 0:
                controls['ExposureTime'] = shutter_val
                print(f"[CONTROL] ExposureTime = {shutter_val}")

        # 2. Analogue Gain
        if 'analoggain' in cfg:
            ag = float(cfg['analoggain'])
            if ag > 0:
                controls['AnalogueGain'] = ag
                print(f"[CONTROL] AnalogueGain = {ag}")

        # 3. Exposure Value (EV compensation)
        if 'ev' in cfg:
            controls['ExposureValue'] = float(cfg['ev'])
            print(f"[CONTROL] ExposureValue = {cfg['ev']}")

        # 4. Brightness
        if 'brightness' in cfg:
            controls['Brightness'] = float(cfg['brightness'])
            print(f"[CONTROL] Brightness = {cfg['brightness']}")

        # 5. Contrast
        if 'contrast' in cfg:
            controls['Contrast'] = float(cfg['contrast'])
            print(f"[CONTROL] Contrast = {cfg['contrast']}")

        # 6. Saturation
        if 'saturation' in cfg:
            controls['Saturation'] = float(cfg['saturation'])
            print(f"[CONTROL] Saturation = {cfg['saturation']}")

        # 7. Sharpness
        if 'sharpness' in cfg:
            controls['Sharpness'] = float(cfg['sharpness'])
            print(f"[CONTROL] Sharpness = {cfg['sharpness']}")

        # 8. AWB Mode (Auto White Balance mode)
        awb_mode = str(cfg.get('awb', 'custom')).lower()
        awbenable = int(cfg.get('awbenable', 0))

        if awb_mode == 'custom':
            # Custom mode: manual colour gains
            controls['AwbEnable'] = False
            awbgains = cfg.get('awbgains', [0.0, 0.0])
            if isinstance(awbgains, str):
                awbgains = [float(v.strip()) for v in awbgains.split(',')]
            if len(awbgains) >= 2:
                # FIX: Always set ColourGains when AWB is disabled, even if 0,0
                # This ensures old values are cleared when user sets 0,0
                red_gain = float(awbgains[0])
                blue_gain = float(awbgains[1])
                controls['ColourGains'] = (red_gain, blue_gain)
                print(f"[CONTROL] ColourGains = ({red_gain}, {blue_gain}) — MANUAL AWB")
        else:
            # Auto AWB mode selected
            controls['AwbEnable'] = True
            # Map string modes to libcamera enum values
            awb_mode_map = {
                'auto': 0,
                'tungsten': 1,
                'fluorescent': 2,
                'indoor': 3,
                'daylight': 4,
                'cloudy': 5,
            }
            if awb_mode in awb_mode_map:
                controls['AwbMode'] = awb_mode_map[awb_mode]
                print(f"[CONTROL] AwbMode = {awb_mode} ({awb_mode_map[awb_mode]})")

        # 9. AWB Enable override (if explicitly set)
        # awbenable=1 means AWB ON (auto), awbenable=0 means AWB OFF (manual)
        if awbenable == 1:
            controls['AwbEnable'] = True
            print("[CONTROL] AwbEnable = True (override)")
        elif awbenable == 0 and 'AwbEnable' not in controls:
            # Only force off if not already set by custom mode
            controls['AwbEnable'] = False
            print("[CONTROL] AwbEnable = False (override)")

        # 10. Denoise mode
        denoise = str(cfg.get('denoise', 'auto')).lower()
        denoise_map = {
            'highquality': 0,
            'off': 1,
            'fast': 2,
        }
        if denoise in denoise_map:
            controls['NoiseReductionMode'] = denoise_map[denoise]
            print(f"[CONTROL] NoiseReductionMode = {denoise} ({denoise_map[denoise]})")

        # 11. Metering mode
        metering = str(cfg.get('metering', 'average')).lower()
        metering_map = {
            'centre': 0,
            'spot': 1,
            'matrix': 2,
            'custom': 3,
        }
        if metering in metering_map:
            controls['AeMeteringMode'] = metering_map[metering]
            print(f"[CONTROL] AeMeteringMode = {metering} ({metering_map[metering]})")

        # 12. Exposure mode (AeExposureMode - NOT AeConstraintMode!)
        exposure = str(cfg.get('exposure', 'normal')).lower()
        exposure_map = {
            'normal': 0,
            'short': 1,
            'long': 2,
            'custom': 3,
        }
        if exposure in exposure_map:
            controls['AeExposureMode'] = exposure_map[exposure]
            print(f"[CONTROL] AeExposureMode = {exposure} ({exposure_map[exposure]})")

        # 13. Constrain mode (AeConstraintMode)
        constrain = str(cfg.get('constrain', 'normal')).lower()
        constrain_map = {
            'normal': 0,
            'highlight': 1,
            'shadows': 2,
            'custom': 3,
        }
        if constrain in constrain_map:
            controls['AeConstraintMode'] = constrain_map[constrain]
            print(f"[CONTROL] AeConstraintMode = {constrain} ({constrain_map[constrain]})")

        # 14. FrameRate via FrameDurationLimits
        framerate = float(cfg.get('framerate', 30.0))
        if framerate > 0:
            frame_duration = int(1e6 / framerate)
            controls['FrameDurationLimits'] = (frame_duration, frame_duration)
            print(f"[CONTROL] FrameDurationLimits = ({frame_duration}, {frame_duration}) for {framerate}fps")

        # Apply all controls
        if controls:
            picam2.set_controls(controls)
            time.sleep(0.2)
            print(f"[CAMERA] Applied {len(controls)} controls for mode '{mode_name}'")
        else:
            print(f"[CAMERA] No controls to apply for mode '{mode_name}'")

        # Verify with test capture
        try:
            test_frame = picam2.capture_array()
            if test_frame is None or test_frame.size == 0:
                print(f"[CAMERA WARNING] Test frame empty after applying {mode_name} config!")
            else:
                print(f"[CAMERA] Verification OK - frame shape: {test_frame.shape}")
        except Exception as ve:
            print(f"[CAMERA WARNING] Verification capture failed: {ve}")

        return True

    except Exception as e:
        print(f"[CAMERA] Error applying mode config '{mode_name}': {e}")
        import traceback
        traceback.print_exc()
        return False
    
# ==========================================
# GPIO LIGHT CONTROL
# ==========================================
def light_on(pin, name=""):
    if GPIO_AVAILABLE:
        GPIO.output(pin, SIGNAL_ON)
    print(f"LIGHT ON  — {name} (Pin {pin})")

def light_off(pin, name=""):
    if GPIO_AVAILABLE:
        GPIO.output(pin, SIGNAL_OFF)
    print(f"LIGHT OFF — {name} (Pin {pin})")

def all_lights_off():
    light_off(WHITE_LED,  "White LED")
    light_off(SW_LED,     "SW LED")
    light_off(FLURO_LED,  "Fluorescence LED")
    light_off(SW_LAMP,    "SW Lamp")
    print("All lights OFF")

# ==========================================
# CAPTURE HELPER
# ==========================================
def capture_with_light_control(temp_path, filename, mode_name,
                                light_pin, delay_before, delay_after,
                                turn_off_after=True):
    print(f"\n--- Capturing {filename} (mode={mode_name}) ---")
    apply_mode_config(mode_name)
    light_on(light_pin, mode_name)
    time.sleep(delay_before)

    frame = get_frame()
    filepath = os.path.join(temp_path, filename)
    cv2.imwrite(filepath, frame)
    print(f"Saved: {filepath}")

    time.sleep(delay_after)

    if turn_off_after:
        light_off(light_pin, mode_name)
    else:
        print(f"Light KEPT ON for next capture ({mode_name})")

    return os.path.exists(filepath)

# ==========================================
# DIAMOND MARKING
# ==========================================
def set_marking(temp_path, super_mode=False):
    try:
        print(f"set_marking: {temp_path}, super_mode={super_mode}")

        image = cv2.imread(os.path.join(temp_path, "whitelight.jpg"))
        if image is None:
            print("ERROR: whitelight.jpg not found")
            return None

        result_image = image.copy()

        img3     = cv2.imread(os.path.join(temp_path, "shortphosphorescence.jpg"))
        img4     = cv2.imread(os.path.join(temp_path, "longphosphorescence.jpg"))
        img_simu = cv2.imread(os.path.join(temp_path, "simulant.jpg"))
        img_flor = cv2.imread(os.path.join(temp_path, "fluorescence.jpg"))

        if any(img is None for img in [img3, img4, img_simu, img_flor]):
            print("ERROR: Some images missing")
            return None

        hpht_bgr = COLORS['hpht']
        cvd_bgr  = COLORS['cvd']
        cvdt_bgr = COLORS['cvd_t']
        simu_bgr = COLORS['simulant']
        rft_bgr  = COLORS['rft']
        ntr_bgr  = COLORS['natural']

        blur_simu = cv2.GaussianBlur(img_simu, (5, 5), 0)
        hsv_simu  = cv2.cvtColor(blur_simu, cv2.COLOR_BGR2HSV)

        m_r1 = cv2.inRange(hsv_simu, np.array([0,  10, 25]), np.array([10,  255, 255]))
        m_r2 = cv2.inRange(hsv_simu, np.array([160,10, 25]), np.array([180, 255, 255]))
        m_pk = cv2.inRange(hsv_simu, np.array([130,10, 25]), np.array([150, 255, 255]))
        m_pp = cv2.inRange(hsv_simu, np.array([150,10, 25]), np.array([160, 255, 255]))
        red_group_s = cv2.bitwise_or(cv2.bitwise_or(m_r1, m_r2), cv2.bitwise_or(m_pk, m_pp))

        m_yl = cv2.inRange(hsv_simu, np.array([25, 10, 25]), np.array([50,  255, 255]))
        m_or = cv2.inRange(hsv_simu, np.array([10, 10, 25]), np.array([25,  255, 255]))
        yel_group_s = cv2.bitwise_or(m_yl, m_or)

        mask_simulant = cv2.bitwise_or(red_group_s, yel_group_s)
        kernel_s      = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (5, 5))
        mask_simulant = cv2.morphologyEx(mask_simulant, cv2.MORPH_OPEN, kernel_s)
        cnts_sim      = imutils.grab_contours(cv2.findContours(
            mask_simulant, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_NONE))

        blur = cv2.medianBlur(img3, 3)
        hsv  = cv2.cvtColor(blur, cv2.COLOR_BGR2HSV)
        hsv4 = cv2.cvtColor(img4,  cv2.COLOR_BGR2HSV)

        lower_red        = np.array([128, 30, 30])
        upper_red        = np.array([179, 255, 255])
        lower_yellow     = np.array([0,   30, 30])
        upper_yellow     = np.array([17,  255, 255])
        lower_green      = np.array([18,  30, 30])
        upper_green      = np.array([80,  255, 255])
        lower_torquoise1 = np.array([80,  30, 100])
        upper_torquoise1 = np.array([105, 255, 255])
        lower_torquoise2 = np.array([80,  10, 20])
        upper_torquoise2 = np.array([105, 255, 119])
        lower_torquoise3 = np.array([80,  10, 120])
        upper_torquoise3 = np.array([105, 255, 255])
        lower_nat        = np.array([105, 30, 30])
        upper_nat        = np.array([129, 255, 255])

        yellow     = cv2.inRange(hsv,  lower_yellow,     upper_yellow)
        green      = cv2.inRange(hsv,  lower_green,      upper_green)
        red        = cv2.inRange(hsv,  lower_red,        upper_red)
        torquoise1 = cv2.inRange(hsv,  lower_torquoise1, upper_torquoise1)
        torquoise2 = cv2.inRange(hsv4, lower_torquoise2, upper_torquoise2)
        torquoise3 = cv2.inRange(hsv4, lower_torquoise3, upper_torquoise3)

        red = np.bitwise_or(red, yellow)

        hsv_short    = cv2.cvtColor(img3, cv2.COLOR_BGR2HSV)
        mask_natural = cv2.inRange(hsv_short, lower_nat, upper_nat)
        kernel       = np.ones((3, 3), np.uint8)
        mask_natural = cv2.morphologyEx(mask_natural, cv2.MORPH_OPEN, kernel)
        mask_natural = cv2.medianBlur(mask_natural, 3)
        cnts_nat     = imutils.grab_contours(cv2.findContours(
            mask_natural, cv2.RETR_TREE, cv2.CHAIN_APPROX_SIMPLE))

        gray_flor       = cv2.cvtColor(img_flor, cv2.COLOR_BGR2GRAY)
        _, mask_flor_glow = cv2.threshold(gray_flor, 100, 255, cv2.THRESH_BINARY)
        kernel_f        = np.ones((3, 3), np.uint8)
        mask_flor_glow  = cv2.morphologyEx(mask_flor_glow, cv2.MORPH_OPEN, kernel_f)

        torquoise_cnt1 = imutils.grab_contours(cv2.findContours(
            torquoise1, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE))
        torquoise_cnt2 = imutils.grab_contours(cv2.findContours(
            torquoise2, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE))
        torquoise_cnt3 = imutils.grab_contours(cv2.findContours(
            torquoise3, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE))
        cnts1 = imutils.grab_contours(cv2.findContours(
            red,   cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_NONE))
        cnts4 = imutils.grab_contours(cv2.findContours(
            green, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_NONE))

        cvd_circles = rft_circles = hpht_circles = cvd_t_circles = 0
        simulant_circles = natural_circles = 0
        hpht_list, cvd_list, rft_list, simulant_list, natural_list, cvd_t_list = [], [], [], [], [], []

        def get_centroid(cnt):
            M = cv2.moments(cnt)
            if M["m00"] == 0:
                return (0, 0)
            return (int(M["m10"] / M["m00"]), int(M["m01"] / M["m00"]))

        def compute_iou(boxA, boxB):
            xA = max(boxA[0], boxB[0]);  yA = max(boxA[1], boxB[1])
            xB = min(boxA[0]+boxA[2], boxB[0]+boxB[2])
            yB = min(boxA[1]+boxA[3], boxB[1]+boxB[3])
            inter = max(0, xB-xA) * max(0, yB-yA)
            union = boxA[2]*boxA[3] + boxB[2]*boxB[3] - inter
            return inter / float(union) if union > 0 else 0

        hpht_candidates = [(c3, cv2.boundingRect(c3)) for c3 in torquoise_cnt3 if cv2.contourArea(c3) > 5]
        cvdt_candidates = [(c2, cv2.boundingRect(c2)) for c2 in torquoise_cnt2 if cv2.contourArea(c2) > 5]

        for cnt1 in torquoise_cnt1:
            if cv2.contourArea(cnt1) <= 5:
                continue
            c1_center = get_centroid(cnt1)
            x1, y1, w1, h1 = cv2.boundingRect(cnt1)
            match_found = False

            for cnt3, (x3, y3, w3, h3) in hpht_candidates:
                dist = np.linalg.norm(np.array(c1_center) - np.array(get_centroid(cnt3)))
                if compute_iou((x1,y1,w1,h1),(x3,y3,w3,h3)) > 0.2 or dist < 30:
                    hpht_list.append(c1_center)
                    cv2.drawContours(result_image, [cnt1], -1, hpht_bgr, -1)
                    hpht_circles += 1
                    match_found = True
                    break

            if match_found:
                continue

            for cnt2, (x2, y2, w2, h2) in cvdt_candidates:
                dist = np.linalg.norm(np.array(c1_center) - np.array(get_centroid(cnt2)))
                if compute_iou((x1,y1,w1,h1),(x2,y2,w2,h2)) > 0.2 or dist < 30:
                    cvd_t_list.append(c1_center)
                    cv2.drawContours(result_image, [cnt1], -1, cvdt_bgr, -1)
                    cvd_t_circles += 1
                    match_found = True
                    break

            if not match_found:
                natural_list.append(c1_center)
                cv2.drawContours(result_image, [cnt1], -1, ntr_bgr, -1)
                natural_circles += 1

        for c in cnts_sim:
            if cv2.contourArea(c) > 40:
                M  = cv2.moments(c)
                cX = int(M["m10"]/M["m00"]) if M["m00"] != 0 else 0
                cY = int(M["m01"]/M["m00"]) if M["m00"] != 0 else 0
                if any(abs(s[0]-cX)<25 and abs(s[1]-cY)<25 for s in (hpht_list+cvd_t_list)):
                    continue
                roi_glow   = mask_flor_glow[max(0,cY-10):min(image.shape[0],cY+10),
                                            max(0,cX-10):min(image.shape[1],cX+10)]
                if cv2.countNonZero(roi_glow) > 15:
                    natural_list.append((cX, cY))
                    cv2.drawContours(result_image, [c], -1, ntr_bgr, -1)
                    natural_circles += 1
                else:
                    simulant_list.append((cX, cY))
                    cv2.drawContours(result_image, [c], -1, simu_bgr, -1)
                    simulant_circles += 1

        for c in cnts_nat:
            if cv2.contourArea(c) < 50:
                continue
            cX, cY = get_centroid(c)
            if any((sx-cX)**2+(sy-cY)**2 < 100 for sx,sy in (hpht_list+cvd_t_list+simulant_list)):
                continue
            natural_list.append((cX, cY))
            natural_circles += 1
            cv2.drawContours(result_image, [c], -1, ntr_bgr, -1)

        for c in cnts1:
            cX, cY = get_centroid(c)
            if cv2.contourArea(c) > 40:
                if not any((i[0]-10)<=cX<=(i[0]+10) and (i[1]-10)<=cY<=(i[1]+10) for i in hpht_list):
                    cvd_list.append((cX, cY))
                    cv2.drawContours(result_image, [c], -1, cvd_bgr, -1)
                    cvd_circles += 1

        for c in cnts4:
            cX, cY = get_centroid(c)
            if cv2.contourArea(c) > 40:
                if any((i[0]-15)<=cX<=(i[0]+15) and (i[1]-15)<=cY<=(i[1]+15) for i in hpht_list):
                    continue
                if any(abs(n[0]-cX)<15 and abs(n[1]-cY)<15 for n in natural_list):
                    continue
                roi_f = mask_flor_glow[max(0,cY-3):min(image.shape[0],cY+3),
                                       max(0,cX-3):min(image.shape[1],cX+3)]
                if cv2.countNonZero(roi_f) > 0:
                    natural_list.append((cX, cY))
                    cv2.drawContours(result_image, [c], -1, ntr_bgr, -1)
                    natural_circles += 1
                else:
                    rft_list.append((cX, cY))
                    cv2.drawContours(result_image, [c], -1, rft_bgr, -1)
                    rft_circles += 1

        all_circles = hpht_circles + cvd_circles + rft_circles + simulant_circles + cvd_t_circles + natural_circles
        cv2.imwrite(os.path.join(temp_path, "result.jpg"), result_image)
        print(f"Marking done! Total: {all_circles}")

        return {
            'hpht': hpht_circles, 'cvd': cvd_circles, 'cvd_t': cvd_t_circles,
            'rft': rft_circles, 'simulant': simulant_circles, 'natural': natural_circles,
            'total': all_circles
        }

    except Exception as e:
        print(f"ERROR in set_marking: {e}")
        import traceback; traceback.print_exc()
        return None

# ==========================================
# VIDEO STREAM
# ==========================================
BOUNDARY     = b'--frame'
CONTENT_TYPE = b'Content-Type: image/jpeg'
CRLF         = b'\r\n'

def generate_frames():
    while True:
        frame = get_frame()
        ret, buffer = cv2.imencode('.jpg', frame)
        frame_bytes = buffer.tobytes()
        yield BOUNDARY + CRLF + CONTENT_TYPE + CRLF + CRLF + frame_bytes + CRLF
        if USE_FAKE:
            time.sleep(0.05)

# ==========================================
# ROUTES — VIDEO / PREVIEW
# ==========================================
@app.route('/')
def index():
    # Clean up old scan when coming to home
    cleanup_old_scan()
    ref_image = None
    for rf in ['reference-image.jpeg', 'reference.jpg', 'ref.jpg', 'reference.png']:
        if os.path.exists(os.path.join(REF_IMAGE_FOLDER, rf)):
            ref_image = rf
            break
    return render_template('index.html', ref_image=ref_image)

@app.route('/video_feed')
def video_feed():
    return Response(generate_frames(), mimetype='multipart/x-mixed-replace; boundary=frame')

@app.route('/start_preview', methods=['POST'])
def start_preview():
    print("Starting preview mode...")
    apply_mode_config('preview')
    light_on(WHITE_LED, "White LED (Preview)")
    return jsonify({"status": "success", "message": "Preview started"})

@app.route('/stop_preview', methods=['POST'])
def stop_preview():
    print("Stopping preview mode...")
    light_off(WHITE_LED, "White LED")
    return jsonify({"status": "success", "message": "Preview stopped"})

# @app.route('/auto_focus', methods=['POST'])
# def auto_focus():
#     try:
#         if USE_PICAMERA2 and PICAMERA2_AVAILABLE and picam2 is not None:
#             picam2.set_controls({"AfMode": 1, "AfTrigger": 0})
#             time.sleep(1.2)
#         elif not USE_FAKE:
#             camera.set(cv2.CAP_PROP_AUTOFOCUS, 1)
#             time.sleep(0.5)
#         return jsonify({"status": "success"})
#     except Exception as e:
#         return jsonify({"status": "error", "message": str(e)})

@app.route('/auto_focus', methods=['POST'])
def auto_focus():
    try:
        if USE_PICAMERA2 and PICAMERA2_AVAILABLE and picam2 is not None:
            try:
                success = picam2.autofocus_cycle()
                print(f"[AUTO FOCUS] autofocus_cycle() result: {success}")
            except AttributeError:
                picam2.set_controls({"AfMode": 1})
                time.sleep(0.2)
                picam2.set_controls({"AfTrigger": 0})
                time.sleep(1.5)
                state = picam2.capture_metadata().get("AfState")
                print(f"[AUTO FOCUS] manual trigger, AfState: {state}")
        elif not USE_FAKE:
            camera.set(cv2.CAP_PROP_AUTOFOCUS, 1)
            time.sleep(0.5)
        return jsonify({"status": "success"})
    except Exception as e:
        print(f"[AUTO FOCUS] error: {e}")
        return jsonify({"status": "error", "message": str(e)})

# ==========================================
# SCAN ROUTE — NO MULTI-DEVICE LOCK, TEMP STORAGE ONLY
# ==========================================
@app.route('/scan', methods=['POST'])
def scan():
    global scan_in_progress, current_scan_folder

    with scan_lock:
        if scan_in_progress:
            return jsonify({"status": "busy", "message": "Scan already in progress. Please wait."}), 423
        scan_in_progress = True

    try:
        super_mode      = request.form.get('super_mode', 'false') == 'true'
        enable_simulant = get_simulant_enabled()

        # ===== CLEAN OLD SCAN & CREATE TEMP FOLDER =====
        cleanup_old_scan()
        timestamp = str(int(time.time()))
        temp_base = tempfile.gettempdir()
        temp_path = os.path.join(temp_base, f"diamond_scan_{timestamp}")
        os.makedirs(temp_path, exist_ok=True)
        current_scan_folder = temp_path

        print(f"\n{'='*60}")
        print(f"SCAN START: {timestamp}  temp_path={temp_path}")
        print(f"super_mode={super_mode}  simulant={enable_simulant}")
        print(f"{'='*60}")

        # Read delays from info.txt
        info      = parse_info_file()
        delay_str = info.get('delay_value', '1.0,0.0,1.0,0.0,2.0')
        delays    = [float(x.strip()) for x in delay_str.split(',')]
        while len(delays) < 5:
            delays.append(0.0)
        print(f"Delays: {delays}")

        update_scan_progress(0, "Scanning...")
        all_lights_off()
        time.sleep(0.2)

        # --------------------------------------------------
        # STEP 1: WHITE LIGHT  (config1)
        # --------------------------------------------------
        print("\n--- STEP 1: WHITE LIGHT ---")
        ok = capture_with_light_control(
            temp_path=temp_path, filename='whitelight.jpg',
            mode_name='whitelight', light_pin=WHITE_LED,
            delay_before=0.5, delay_after=0.0
        )
        if not ok:
            raise Exception("White light capture failed")
        update_scan_progress(20, "Scanning...")

        # --------------------------------------------------
        # STEP 2: FLUORESCENCE  (config2)
        # --------------------------------------------------
        print(f"\n--- STEP 2: FLUORESCENCE (delay={delays[0]}s) ---")
        time.sleep(delays[0])
        ok = capture_with_light_control(
            temp_path=temp_path, filename='fluorescence.jpg',
            mode_name='fluorescence', light_pin=FLURO_LED,
            delay_before=delays[0], delay_after=0.0
        )
        if not ok:
            raise Exception("Fluorescence capture failed")
        update_scan_progress(40, "Scanning...")

        # --------------------------------------------------
        # STEP 3: SHORT PHOSPHORESCENCE  (config3)
        #         SW_LAMP stays ON for superimage!
        # --------------------------------------------------
        print(f"\n--- STEP 3: SHORT PHOSPHORESCENCE (delay={delays[2]}s) ---")
        time.sleep(delays[1])
        ok = capture_with_light_control(
            temp_path=temp_path, filename='shortphosphorescence.jpg',
            mode_name='shortphosphorescence', light_pin=SW_LAMP,
            delay_before=delays[2], delay_after=0.0,
            turn_off_after=False
        )
        if not ok:
            raise Exception("Short phosphorescence capture failed")
        update_scan_progress(50, "Scanning...")

        # --------------------------------------------------
        # STEP 4: SUPER IMAGE  (config5) — SW_LAMP still ON
        # --------------------------------------------------
        if super_mode:
            print("\n--- STEP 4: SUPER IMAGE (SW_LAMP still ON, config5 gain) ---")
            apply_mode_config('superimage')
            time.sleep(0.3)
            frame = get_frame()
            cv2.imwrite(os.path.join(temp_path, 'superimage.jpg'), frame)
            print("Saved: superimage.jpg  (SW_LAMP ON, superimage gain)")
        else:
            print("\n--- STEP 4: SUPER IMAGE SKIPPED ---")
        update_scan_progress(60, "Scanning...")

        # --------------------------------------------------
        # STEP 5: LONG PHOSPHORESCENCE  (config4)
        # --------------------------------------------------
        print(f"\n--- STEP 5: LONG PHOSPHORESCENCE (delay={delays[3]}s) ---")
        light_off(SW_LAMP, "SW Lamp")
        time.sleep(delays[3])
        apply_mode_config('longphosphorescence')
        time.sleep(0.3)
        frame = get_frame()
        cv2.imwrite(os.path.join(temp_path, 'longphosphorescence.jpg'), frame)
        print("Saved: longphosphorescence.jpg  (SW_LAMP OFF — phosphor decay)")
        update_scan_progress(80, "Scanning...")

        # --------------------------------------------------
        # STEP 6: SIMULANT  (config6) — SW_LED
        # --------------------------------------------------
        if enable_simulant:
            print(f"\n--- STEP 6: SIMULANT (delay={delays[4]}s) ---")
            time.sleep(delays[1])
            ok = capture_with_light_control(
                temp_path=temp_path, filename='simulant.jpg',
                mode_name='simulant', light_pin=SW_LED,
                delay_before=delays[4], delay_after=0.0
            )
            if not ok:
                raise Exception("Simulant capture failed")
        else:
            print("\n--- STEP 6: SIMULANT SKIPPED ---")
        update_scan_progress(100, "Scanning...")

        # Restore preview
        print("\n--- RESTORING PREVIEW ---")
        apply_mode_config('preview')
        light_on(WHITE_LED, "White LED (Preview)")

        # Image processing
        print(f"\n{'='*60}")
        print("PROCESSING IMAGES...")
        stats = set_marking(temp_path, super_mode=super_mode)

        if stats is None:
            all_lights_off()
            scan_in_progress = False
            return jsonify({"status": "error", "message": "Marking failed"}), 500

        print(f"SCAN COMPLETE! Total diamonds: {stats['total']}")
        print(f"{'='*60}\n")

        light_on(WHITE_LED, "White LED (Preview)")
        scan_in_progress = False

        return jsonify({
            "status":        "success",
            "path":          timestamp,
            "stats":         stats,
            "super_mode":    super_mode,
            "simulant_mode": enable_simulant,
        })

    except Exception as e:
        print(f"\nSCAN ERROR: {e}")
        global scan_progress
        scan_progress = {'percent': 0, 'step': f'Error: {str(e)}', 'status': 'error'}
        all_lights_off()
        scan_in_progress = False
        return jsonify({"status": "error", "message": str(e)}), 500

# ==========================================
# RESULTS & IMAGES — SERVE FROM TEMP FOLDER
# ==========================================
@app.route('/results/<path>')
def results(path):
    global current_scan_folder
    if not current_scan_folder or not os.path.exists(current_scan_folder):
        return "No scan data available. Please scan first.", 404

    super_exists = os.path.exists(os.path.join(current_scan_folder, 'superimage.jpg'))
    ref_image = None
    for rf in ['reference-image.jpeg', 'reference.jpg', 'ref.jpg', 'reference.png']:
        if os.path.exists(os.path.join(REF_IMAGE_FOLDER, rf)):
            ref_image = rf
            break
    return render_template('results.html', path=path, super_exists=super_exists, ref_image=ref_image)

@app.route('/ref_image/<filename>')
def ref_image(filename):
    fp = os.path.join(REF_IMAGE_FOLDER, filename)
    return send_file(fp, mimetype='image/jpeg') if os.path.exists(fp) else ("Not found", 404)

@app.route('/image/<path>/<filename>')
def get_image(path, filename):
    global current_scan_folder
    if not current_scan_folder:
        return "No scan data", 404
    fp = os.path.join(current_scan_folder, filename)
    return send_file(fp, mimetype='image/jpeg') if os.path.exists(fp) else ("Not found", 404)

# ==========================================
# DOWNLOAD ZIP — FROM TEMP FOLDER
# ==========================================
@app.route('/download/<path>')
def download_all(path):
    global current_scan_folder
    if not current_scan_folder or not os.path.exists(current_scan_folder):
        return "Folder not found", 404

    custom_name = request.args.get('name', 'diamond_scan')
    custom_name = re.sub(r'[^a-zA-Z0-9_-]', '', custom_name) or 'diamond_scan'

    memory_file = io.BytesIO()
    files_to_zip = ['result.jpg', 'whitelight.jpg', 'fluorescence.jpg',
                    'shortphosphorescence.jpg', 'longphosphorescence.jpg', 'simulant.jpg']
    if os.path.exists(os.path.join(current_scan_folder, 'superimage.jpg')):
        files_to_zip.append('superimage.jpg')

    with zipfile.ZipFile(memory_file, 'w', zipfile.ZIP_DEFLATED) as zf:
        for fn in files_to_zip:
            fp = os.path.join(current_scan_folder, fn)
            if os.path.exists(fp):
                zf.write(fp, fn)

    memory_file.seek(0)
    return send_file(
        memory_file,
        mimetype='application/zip',
        as_attachment=True,
        # attachment_filename=f"{custom_name}.zip"
        download_name=f"{custom_name}.zip"
    )

# ==========================================
# CONFIG SETTINGS ROUTES
# ==========================================
@app.route('/settings')
def settings_page():
    return render_template('setting.html')

@app.route('/get_all_configs')
def get_all_configs():
    configs = {}
    for key in CONFIG_FILES:
        cfg = read_config_file(key)
        serialised = {}
        for k, v in cfg.items():
            serialised[k] = ','.join(str(x) for x in v) if isinstance(v, list) else str(v)
        configs[key] = serialised
    return jsonify({"status": "success", "configs": configs})

@app.route('/save_all_configs', methods=['POST'])
def save_all_configs():
    try:
        data    = request.get_json()
        configs = data.get('configs', {})
        for key, config_data in configs.items():
            if key in CONFIG_FILES:
                write_config_file(key, config_data)
        # Restart camera with new width/height/transform settings
        restart_camera_with_config()
        return jsonify({"status": "success", "message": "Configs saved and camera restarted"})
    except Exception as e:
        return jsonify({"status": "error", "message": str(e)})

@app.route('/get_info')
def get_info():
    return jsonify({"status": "success", "info": parse_info_file()})

@app.route('/save_info', methods=['POST'])
def save_info():
    try:
        write_info_file(request.get_json())
        return jsonify({"status": "success", "message": "Info saved"})
    except Exception as e:
        return jsonify({"status": "error", "message": str(e)})

@app.route('/apply_config/<config_name>')
def apply_config(config_name):
    mode_map_reverse = {v: k for k, v in MODE_TO_CONFIG.items()}
    mode = mode_map_reverse.get(config_name, 'preview')
    success = apply_mode_config(mode)
    if success:
        return jsonify({"status": "success", "message": f"Config {config_name} applied"})
    return jsonify({"status": "error", "message": "Failed to apply config"})

@app.route('/scan_progress')
def scan_progress_endpoint():
    return jsonify(scan_progress)

@app.route('/scan_status')
def scan_status():
    return jsonify({
        "scanning": scan_in_progress,
        "elapsed":  0,
    })

# ==========================================
# MAIN
# ==========================================
if __name__ == "__main__":
    ip_address = "127.0.0.1"
    try:
        result = subprocess.run(['ip', 'addr', 'show', 'wlan0'],
                                capture_output=True, text=True, timeout=2)
        if result.returncode == 0:
            m = re.search(r'inet\s+(\d+\.\d+\.\d+\.\d+)', result.stdout)
            if m:
                ip = m.group(1)
                if not ip.startswith('127.'):
                    ip_address = ip
    except Exception:
        pass

    print("\n" + "=" * 60)
    print("DIAMOND CLASSIFIER WEB APP")
    print("=" * 60)
    print(f"  Laptop/PC:     http://localhost:5000")
    print(f"  Mobile/Tablet: http://{ip_address}:5000")
    print("=" * 60)
    print(f"  Camera Mode:   {'FAKE' if USE_FAKE else 'REAL (IMX708)'}")
    print(f"  GPIO:          {GPIO_AVAILABLE}")
    print(f"  Storage:       TEMP ONLY (no permanent saves)")
    print(f"  Pins: WHITE_LED={WHITE_LED}, FLURO_LED={FLURO_LED}")
    print(f"        SW_LAMP={SW_LAMP}, SW_LED={SW_LED}")
    print("=" * 60 + "\n")

    try:
        app.run(host='0.0.0.0', port=5000, debug=False)
    finally:
        cleanup_old_scan()
        cleanup_gpio()