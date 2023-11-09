import paho.mqtt.client as mqtt
import json, random
from time import sleep
 
client = mqtt.Client(protocol = mqtt.MQTTv31)
client.connect("127.0.0.1", 1883)
 
# Univem
devices = [
    "A1234",
    "A1235",
    "A1236",
    "A1237",
]
latitude = -22.233361104467544
longitude = -49.965099637772916
device_id = devices[random.randint(0, len(devices))]

while True:
    
    locationData = {
        "device_id": device_id,
        "latitude": latitude,
        "longitude": longitude
    }

    topic = "device/" + device_id
    client.publish(topic, json.dumps(locationData), qos=1)
    print(topic + " => " + json.dumps(locationData))

    increment_distancia = random.uniform(-0.95, 0.05)
    latitude += increment_distancia
    longitude += increment_distancia

    sleep(3)
