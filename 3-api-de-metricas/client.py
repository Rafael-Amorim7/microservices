import grpc
import metrics_pb2
import metrics_pb2_grpc


def run():
    print("Will try to greet world ...")
    with grpc.insecure_channel("localhost:50051") as channel:
        stub = metrics_pb2_grpc.MetricsServiceStub(channel)
        response = stub.SendMetrics(metrics_pb2.MetricsRequest(
          latitude = 12.1234,
          longitude = -12.1234,
          brand = "Apple",
          date = "2015-10-12",
          device_id = "01JPMCQQ"
        ))
    print("Greeter client received: " + response.message)


if __name__ == "__main__":
    run()
