<?php
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;

WebSocketsRouter::webSocket('/ws', 'LocationController@handleWebSocket');
