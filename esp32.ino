#include <WiFi.h>
#include <HTTPClient.h>
#include <DHT.h>


const char* ssid = "Vodafone-E25037";
const char* password = "Azeitona2022";
String server_url = "http://192.168.1.92/ProjetoTI/api/api.php"; // Change to your server URL
String get_estado_url = "http://192.168.1.92/ProjetoTI/api/get_estado.php";



#define DHTPIN 4 //Sensor
#define led_pin 5  //led


#define DHTTYPE DHT11   
DHT dht(DHTPIN, DHTTYPE);

String led_name = "led_esp";
String temp_name = "Temperatura";
String humid_name = "Humidade";


float last_temp = -100.0;
float last_humid = -100.0;
unsigned long last_check_time = 0;
const int check_interval = 2000; 

void setup() {
  Serial.begin(115200);
  pinMode(led_pin, OUTPUT);
  digitalWrite(led_pin, LOW); 

  dht.begin();


  Serial.print("Connecting to ");
  Serial.println(ssid);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nWiFi connected.");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  unsigned long current_time = millis();

  if (current_time - last_check_time > check_interval) {
   
    float h = dht.readHumidity();
    float t = dht.readTemperature(); 

    if (isnan(h) || isnan(t)) {
      Serial.println("Failed to read from DHT sensor!");
    } else {
      Serial.print("Humidity: ");
      Serial.print(h);
      Serial.print("%\tTemperature: ");
      Serial.print(t);
      Serial.println(" *C");

     
      if (abs(t - last_temp) > 0.5 || abs(h - last_humid) > 1.0) {
        Serial.println("Sensor values changed. Updating server.");
        updateServer(temp_name, String(t, 2) + " C");
        updateServer(humid_name, String(h, 2) + " %");
        last_temp = t;
        last_humid = h;
      }
    }

    
    String led_state = getServerValue(led_name);
    Serial.print("Got LED state from server: ");
    Serial.println(led_state);

    if (led_state == "Ligado") {
      digitalWrite(led_pin, HIGH);
    } else if (led_state == "Desligado") {
      digitalWrite(led_pin, LOW);
    }

    last_check_time = current_time;
  }
}


void updateServer(String name, String value) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(server_url);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    String timestamp = String(time(nullptr));
    String post_data = "nome=" + name + "&valor=" + value + "&hora=ESP32";

    int httpResponseCode = http.POST(post_data);
    if (httpResponseCode > 0) {
      Serial.print(name);
      Serial.print(" update response code: ");
      Serial.println(httpResponseCode);
    } else {
      Serial.print("Error on sending POST: ");
      Serial.println(httpResponseCode);
    }
    http.end();
  }
}


String getServerValue(String name) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    String request_url = get_estado_url + "?nome=" + name;
    http.begin(request_url);
    
    int httpResponseCode = http.GET();
    if (httpResponseCode > 0) {
      String payload = http.getString();
      http.end();
      return payload;
    } else {
      Serial.print("Error on GET request: ");
      Serial.println(httpResponseCode);
      http.end();
      return "Error";
    }
  }
  return "Error";
}