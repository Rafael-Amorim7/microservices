<?php

namespace App\Jobs;

use App\Models\Device;
use App\Models\Location;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ProcessarMensagemRabbitMQ implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected object $data)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = $this->data;

        $cacheKey = 'devices:' . $data->device_id;

        $device = Device::where('codigo', $data->device_id)->first();

        if ($device) {
            $latitude = $data->latitude;
            $longitude = $data->longitude;

            Redis::set($cacheKey, json_encode([$latitude, $longitude]));

            Location::create([
                'device_id' => $device->id,
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);

            $now = date('Y-m-d');
            $output = shell_exec("python app/Utils/metrics/client.py $latitude $longitude $device->marca $now $data->device_id");
            Log::info("Client metrics python: ". $output);
            return;
        }
        Log::info("Device not found: {$data->device_id} - ({$data->latitude}, {$data->longitude})");
    }
}
