#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

const char* ssid = "STARLINK";


String serverURL = "http://192.168.1.197/esp_leds/ESP8266_LEDs.php";

int ledPins[8] = {D0, D1, D2, D3, D4, D5, D6, D7};

void setup() {
  Serial.begin(115200);
  
  for (int i = 0; i < 8; i++) {
    pinMode(ledPins[i], OUTPUT);
    digitalWrite(ledPins[i], LOW);
  }

  WiFi.begin(ssid);
  Serial.print("Connecting to WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nConnected!");
}

void loop() {
  if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client;
    HTTPClient http;

    http.begin(client, serverURL);
    int httpCode = http.GET();

    if (httpCode > 0) {
      String payload = http.getString();
      Serial.println("Server Response: " + payload);

      // Example payload: "10110011" (1 = ON, 0 = OFF)
      if (payload.length() == 8) {
        for (int i = 0; i < 8; i++) {
          if (payload.charAt(i) == '1') {
            digitalWrite(ledPins[i], HIGH);
          } else {
            digitalWrite(ledPins[i], LOW);
          }
        }
      }
    }
    http.end();
  }

  delay(2000); // check server every 2s
}
