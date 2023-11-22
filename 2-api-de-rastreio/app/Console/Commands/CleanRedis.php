<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class CleanRedis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-redis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $prefix = 'laravel_database_';
        $devices_cached = Redis::keys("*");

        foreach ($devices_cached as $device) {
            $device = str_replace($prefix, '', $device); // remove o prefixo
            $redis = Redis::del($device);
            $this->info('Cache Redis status: ' . $redis);
        }

    }
}
