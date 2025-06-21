import requests
import RPi.GPIO as GPIO
import time


API_URL = "http://192.168.1.92/ProjetoTI/api/api.php"
GET_ESTADO_URL = "http://192.168.1.92/ProjetoTI/api/get_estado.php"

MOTION_SENSOR_PIN = 6
PI_LED_PIN = 3


MOTION_SENSOR_NAME = "Movimento"
VENTILADOR_NAME = "ventilador"  
PORTA_NAME = "porta"            
TEMP_SENSOR_NAME = "Temperatura"
HUMID_SENSOR_NAME = "Humidade"

PI_LED_TARGET = "led_pi"
ESP32_LED_TARGET = "led_esp"


GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
GPIO.setup(MOTION_SENSOR_PIN, GPIO.IN)
GPIO.setup(PI_LED_PIN, GPIO.OUT)
GPIO.output(PI_LED_PIN, GPIO.LOW)

last_temp_value = "not_initialized"
last_humid_value = "not_initialized"
last_pi_led_state = ""

def update_server_value(name, value):
    try:
        payload = {
            'nome': name,
            'valor': value,
            'hora': time.strftime('%Y-%m-%d %H:%M:%S')
        }
        response = requests.post(API_URL, data=payload, timeout=5)
        if response.status_code != 200:
            print(f"Error updating {name}. Status: {response.status_code}")
    except requests.exceptions.RequestException as e:
        print(f"Error connecting to server to POST: {e}")

def get_server_value(name):
    try:
        response = requests.get(f"{GET_ESTADO_URL}?nome={name}", timeout=5)
        if response.status_code == 200:
            return response.text.strip()
        else:
            return "Error"
    except requests.exceptions.RequestException as e:
        return "Error"

def blink_led(pin, duration=1, repeat=2):
    for _ in range(repeat):
        GPIO.output(pin, GPIO.HIGH)
        time.sleep(duration / (2 * repeat))
        GPIO.output(pin, GPIO.LOW)
        time.sleep(duration / (2 * repeat))



try:
    print("Starting IoT controller on Raspberry Pi...")
    while True:
        
        if GPIO.input(MOTION_SENSOR_PIN):
            print("Motion Detected! -> Opening/Closing the 'Porta'")
            update_server_value(MOTION_SENSOR_NAME, "Movimento Detetado")
            
            
            update_server_value(PORTA_NAME, "Ligado")
            update_server_value(ESP32_LED_TARGET, "Ligado")
            
            time.sleep(2)
            
            
            update_server_value(PORTA_NAME, "Desligado")
            update_server_value(ESP32_LED_TARGET, "Desligado")
            
            time.sleep(5)
        else:
            update_server_value(MOTION_SENSOR_NAME, "Sem Movimento")

        print("\n--- Checking for temp/humid change ---")
        
      
        current_temp = get_server_value(TEMP_SENSOR_NAME)
        current_humid = get_server_value(HUMID_SENSOR_NAME)

        if current_temp == "Error" or current_humid == "Error":
            print("-> Could not retrieve sensor data.")
        elif last_temp_value == "not_initialized":
            last_temp_value = current_temp
            last_humid_value = current_humid
        elif current_temp != last_temp_value or current_humid != last_humid_value:
            print("-> CHANGE DETECTED! -> Activating 'Ventilador'")
            
            
            blink_led(PI_LED_PIN)
            
            
            update_server_value(VENTILADOR_NAME, "Ligado")
            time.sleep(1)
            update_server_value(VENTILADOR_NAME, "Desligado")

            last_temp_value = current_temp
            last_humid_value = current_humid
        else:
            print("-> No change detected.")

       
        ventilador_command = get_server_value(PI_LED_TARGET) 
        if ventilador_command != "Error" and ventilador_command != last_pi_led_state:
            print(f"-> New command for Ventilador from dashboard: {ventilador_command}")
            if ventilador_command == "Ligado":
                GPIO.output(PI_LED_PIN, GPIO.HIGH)
            else:
                GPIO.output(PI_LED_PIN, GPIO.LOW)
            last_pi_led_state = ventilador_command

        time.sleep(3)

except KeyboardInterrupt:
    print("Stopping controller.")
    GPIO.cleanup()
