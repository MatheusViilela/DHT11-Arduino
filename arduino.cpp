#include <DHT.h>

#define DHTPIN 2          // Pino do sensor DHT11
#define DHTTYPE DHT11     // Tipo do sensor DHT11

DHT dht(DHTPIN, DHTTYPE);

void setup() {
  Serial.begin(9600);    // Inicializa a comunicação serial com o computador
  dht.begin();           // Inicializa o sensor DHT11
}

void loop() {
  float temperature = dht.readTemperature();  // Lê a temperatura do sensor DHT11
  float humidity = dht.readHumidity();        // Lê a umidade do sensor DHT11

  Serial.print("Temperatura: ");
  Serial.print(temperature);
  Serial.print(" C, Umidade: ");
  Serial.print(humidity);
  Serial.println(" %");

  delay(10000);           // Aguarda 2 segundos antes de ler os dados do sensor novamente
}
