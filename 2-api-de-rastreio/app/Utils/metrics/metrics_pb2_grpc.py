import grpc
import metrics_pb2 as metrics__pb2
class MetricsServiceStub(object):
    def __init__(self, channel):
        self.SendMetrics = channel.unary_unary(
                '/metrics.MetricsService/SendMetrics',
                request_serializer=metrics__pb2.MetricsRequest.SerializeToString,
                response_deserializer=metrics__pb2.MetricsResponse.FromString,
                )
        self.SendMetricsStreamReply = channel.unary_stream(
                '/metrics.MetricsService/SendMetricsStreamReply',
                request_serializer=metrics__pb2.MetricsRequest.SerializeToString,
                response_deserializer=metrics__pb2.MetricsResponse.FromString,
                )
class MetricsServiceServicer(object):
    def SendMetrics(self, request, context):
        context.set_code(grpc.StatusCode.UNIMPLEMENTED)
        context.set_details('Method not implemented!')
        raise NotImplementedError('Method not implemented!')
    def SendMetricsStreamReply(self, request, context):
        context.set_code(grpc.StatusCode.UNIMPLEMENTED)
        context.set_details('Method not implemented!')
        raise NotImplementedError('Method not implemented!')
def add_MetricsServiceServicer_to_server(servicer, server):
    rpc_method_handlers = {
            'SendMetrics': grpc.unary_unary_rpc_method_handler(
                    servicer.SendMetrics,
                    request_deserializer=metrics__pb2.MetricsRequest.FromString,
                    response_serializer=metrics__pb2.MetricsResponse.SerializeToString,
            ),
            'SendMetricsStreamReply': grpc.unary_stream_rpc_method_handler(
                    servicer.SendMetricsStreamReply,
                    request_deserializer=metrics__pb2.MetricsRequest.FromString,
                    response_serializer=metrics__pb2.MetricsResponse.SerializeToString,
            ),
    }
    generic_handler = grpc.method_handlers_generic_handler(
            'metrics.MetricsService', rpc_method_handlers)
    server.add_generic_rpc_handlers((generic_handler,))
class MetricsService(object):
    @staticmethod
    def SendMetrics(request,
            target,
            options=(),
            channel_credentials=None,
            call_credentials=None,
            insecure=False,
            compression=None,
            wait_for_ready=None,
            timeout=None,
            metadata=None):
        return grpc.experimental.unary_unary(request, target, '/metrics.MetricsService/SendMetrics',
            metrics__pb2.MetricsRequest.SerializeToString,
            metrics__pb2.MetricsResponse.FromString,
            options, channel_credentials,
            insecure, call_credentials, compression, wait_for_ready, timeout, metadata)
    @staticmethod
    def SendMetricsStreamReply(request,
            target,
            options=(),
            channel_credentials=None,
            call_credentials=None,
            insecure=False,
            compression=None,
            wait_for_ready=None,
            timeout=None,
            metadata=None):
        return grpc.experimental.unary_stream(request, target, '/metrics.MetricsService/SendMetricsStreamReply',
            metrics__pb2.MetricsRequest.SerializeToString,
            metrics__pb2.MetricsResponse.FromString,
            options, channel_credentials,
            insecure, call_credentials, compression, wait_for_ready, timeout, metadata)
