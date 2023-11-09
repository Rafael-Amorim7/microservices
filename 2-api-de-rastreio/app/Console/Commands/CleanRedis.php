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
        $currentDate = now();

        $cachedDate = Redis::get('redis_cache_date');

        if ($cachedDate !== $currentDate->toDateString()) {
            Redis::del('devices');
            Redis::set('redis_cache_date', $currentDate->toDateString());
            $this->info('Cache Redis limpo com sucesso.');
        } else {
            $this->info('Cache Redis já limpo para hoje.');
        }
    }
}
