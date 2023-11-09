<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class WebsocketEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $device_id;
    public float $lat;
    public float $lng;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($device_id, $lat, $lng)
    {
        $this->device_id = $device_id;
        $this->lat = $lat; // Importante este nome ser igual no frontend
        $this->lng = $lng; // Importante este nome ser igual no frontend
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // TODO: Consultar se existe device com codigo == this->device_id
        return [ new Channel($this->device_id) ];
    }
}
