from google.protobuf import descriptor as _descriptor
from google.protobuf import message as _message
from typing import ClassVar as _ClassVar, Optional as _Optional

DESCRIPTOR: _descriptor.FileDescriptor

class MetricsRequest(_message.Message):
    __slots__ = ["latitude", "longitude", "brand", "date", "device_id"]
    LATITUDE_FIELD_NUMBER: _ClassVar[int]
    LONGITUDE_FIELD_NUMBER: _ClassVar[int]
    BRAND_FIELD_NUMBER: _ClassVar[int]
    DATE_FIELD_NUMBER: _ClassVar[int]
    DEVICE_ID_FIELD_NUMBER: _ClassVar[int]
    latitude: float
    longitude: float
    brand: str
    date: str
    device_id: str
    def __init__(self, latitude: _Optional[float] = ..., longitude: _Optional[float] = ..., brand: _Optional[str] = ..., date: _Optional[str] = ..., device_id: _Optional[str] = ...) -> None: ...

class MetricsResponse(_message.Message):
    __slots__ = ["message"]
    MESSAGE_FIELD_NUMBER: _ClassVar[int]
    message: str
    def __init__(self, message: _Optional[str] = ...) -> None: ...
