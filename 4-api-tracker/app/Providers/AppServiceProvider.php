<?php

namespace App\Providers;

use App\Http\Services\ConsumeGraphqlInterface;
use App\Services\MyGraphqlService;
use App\Services\OthersGraphqlService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $interface = ConsumeGraphqlInterface::class;

        if (OthersGraphqlService::isUP()){
            $implement = OthersGraphqlService::class;
        }
        else if (MyGraphqlService::isUP()){
            $implement = MyGraphqlService::class;
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
