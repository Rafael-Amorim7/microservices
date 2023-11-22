<?php

namespace App\Providers;

use Exception;
use App\Services\MyGraphqlService;
use App\Services\OthersGraphqlService;
use Illuminate\Support\ServiceProvider;
use App\Http\Services\ConsumeGraphqlInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     * @throws Exception
     */
    public function register()
    {
        $interface = ConsumeGraphqlInterface::class;

        if (OthersGraphqlService::isUP()){
            $implement = OthersGraphqlService::class;
        }
        else if (MyGraphqlService::isUP()){
            $implement = MyGraphqlService::class;
        } else {
            throw new Exception('GraphQL service is down :(');
        }
        $this->app->bind(
            $interface,
            $implement
        );

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
