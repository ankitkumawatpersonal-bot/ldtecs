import RPi.GPIO as GPIO
import time

GPIO.setmode(GPIO.BOARD)

white_led = 8 # White Light PCB-2
sw_led = 18 # SW Led PCB-2 
# sw_led = 16 # SW Led PCB-2 burned in CLA002 Rpi
fluro_led = 23 # Fluro Led PCB-2
sw_lamp = 10 # SW Lamp PCB-2
fan = 24 # FAN PCB-2


GPIO.setup(white_led, GPIO.OUT)          
GPIO.setup(sw_led, GPIO.OUT) 
GPIO.setup(fluro_led, GPIO.OUT) 
GPIO.setup(sw_lamp, GPIO.OUT) 
GPIO.setup(fan, GPIO.OUT)  

GPIO.output(white_led, GPIO.LOW)
GPIO.output(sw_led, GPIO.LOW)
GPIO.output(fluro_led, GPIO.LOW)
GPIO.output(sw_lamp, GPIO.LOW)
GPIO.output(fan, GPIO.LOW)

# GPIO.output(white_led, GPIO.HIGH)
# GPIO.output(sw_led, GPIO.HIGH)
# GPIO.output(fluro_led, GPIO.HIGH) 
# GPIO.output(sw_lamp, GPIO.HIGH)
GPIO.output(fan, GPIO.HIGH)

time.sleep( 2 )

# GPIO.output(white_led, GPIO.LOW)
# GPIO.output(sw_led, GPIO.LOW)
# GPIO.output(fluro_led, GPIO.LOW)
# GPIO.output(sw_lamp, GPIO.LOW)
GPIO.output(fan, GPIO.LOW)
# 
