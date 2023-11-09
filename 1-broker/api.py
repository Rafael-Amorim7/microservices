import paho.mqtt.client as mqtt
import pika

def send_to_rabbitmq(data):
    connection = pika.BlockingConnection(pika.ConnectionParameters('localhost'))
    channel = connection.channel()
    channel.queue_declare(queue='location_queue')
    channel.basic_publish(exchange='', routing_key='location_queue', body=data)
    connection.close()
 
def on_connect(client, data, rc, properties=None):
    client.subscribe([("device/#",1)])
 
def on_message(client, userdata, msg):
    payload = msg.payload.decode('utf-8')
    print(msg.topic + " => " + payload)
    send_to_rabbitmq(payload)
 
client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message
 
client.connect("127.0.0.1", 1883)
 
client.loop_forever()