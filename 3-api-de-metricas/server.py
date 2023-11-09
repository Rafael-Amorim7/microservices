import grpc
import metrics_pb2
import metrics_pb2_grpc
from geopy.distance import geodesic
from geopy.geocoders import Nominatim

from concurrent import futures

import mysql.connector
from mysql.connector import errorcode


# Instancie o geocoder do Nominatim para obter coordenadas geográficas a partir de nomes de localização
geolocator = Nominatim(user_agent="metrics_app")


class MetricsService(metrics_pb2_grpc.MetricsServiceServicer):
    def SendMetrics(self, request, context):
        device_id = request.device_id
        device_name = request.brand
        last_location = f"{request.latitude}|{request.longitude}"
        date = request.date

        try:
            connection = mysql.connector.connect(user='sherlock',
                                                 password='',
                                                 host='127.0.0.1',
                                                 database='rastreio')
            cursorQuery = connection.cursor(buffered=True)

            select = (f"SELECT device_id "
                      "FROM rastreio.metrics "
                      "WHERE device_id = %s")

            cursorQuery.execute(select, (device_id,))
            dispositivo = cursorQuery.fetchone()

            if (dispositivo != None):
                self.updateDevice(connection, device_id, last_location, date)

            else:
                self.insertDevice(connection, device_id,
                                  device_name, last_location, date)

            cursorQuery.close()
            connection.close()

            return metrics_pb2.MetricsResponse(message="Okay")

        except mysql.connector.Error as err:
            if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
                print("Nome de usuário ou senha errada")
            elif err.errno == errorcode.ER_BAD_DB_ERROR:
                print("Database inexistente")
            else:
                print("Erro:", err)

    def updateDevice(self, connection, device_id, last_location, date):
        cursorUpdate = connection.cursor(buffered=True)
        select = ("SELECT last_location, position_count, total_distance "
                  "FROM rastreio.metrics "
                  "WHERE device_id = %s")

        cursorUpdate.execute(select, (device_id,))
        currentLocation, currentPositionCount, currentTotalDistance = cursorUpdate.fetchone()

        newPositionCount = currentPositionCount + 1
        newTotalDistance = self.calcular_distancia(
            last_location, currentLocation) + currentTotalDistance

        update = ("UPDATE rastreio.metrics "
                  "SET last_location = %s, "
                  "position_count = %s, "
                  "total_distance = %s, "
                  "date = %s "
                  "WHERE device_id = %s")

        paramsUpdate = (last_location, newPositionCount,
                        newTotalDistance, date, device_id)

        cursorUpdate.execute(update, paramsUpdate)
        connection.commit()

        print("Dispositivo atualizado")

    def insertDevice(self, connection, device_id, device_name, last_location, date):
        cursorInsert = connection.cursor(buffered=True)

        insert = ("INSERT INTO rastreio.metrics "
                  "(device_id, brand, last_location, position_count, total_distance, date) "
                  "VALUES (%s, %s, %s, %s, %s, %s)")

        paramsInsert = (device_id, device_name, last_location, 1, 0, date)

        cursorInsert.execute(insert, paramsInsert)
        connection.commit()

        print("Inserido na tabela")

    def calcular_distancia(self, lastLocation, currentLocation):
        lastLocation = [float(coord.strip().replace(",", "."))
                        for coord in lastLocation.split("|")]
        currentLocation = [float(coord.strip().replace(",", "."))
                           for coord in currentLocation.split("|")]

        lastLocationCoord = (lastLocation[0], lastLocation[1])
        currentLocationCoord = (currentLocation[0], currentLocation[1])

        distancia = geodesic(
            lastLocationCoord, currentLocationCoord).kilometers
        return distancia

def serve():
    port = "50051"
    server = grpc.server(futures.ThreadPoolExecutor(max_workers=10))
    metrics_pb2_grpc.add_MetricsServiceServicer_to_server(MetricsService(), server)
    server.add_insecure_port("[::]:" + port)
    server.start()
    print("Server started, listening on " + port)
    server.wait_for_termination()


if __name__ == "__main__":
    serve()
