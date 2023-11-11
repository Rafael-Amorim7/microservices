import sys
import grpc
import metrics_pb2
import metrics_pb2_grpc


def run():
    print("Will try to greet world ...")
    with grpc.insecure_channel("localhost:50051") as channel:
        stub = metrics_pb2_grpc.MetricsServiceStub(channel)
        response = stub.SendMetrics(metrics_pb2.MetricsRequest(
          latitude = float(sys.argv[1]),
          longitude = float(sys.argv[2]),
          brand = sys.argv[3],
          date = sys.argv[4],
          device_id = sys.argv[5]
        ))
    print("Greeter client received: " + response.message)

if __name__ == "__main__":
    run()
