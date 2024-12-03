<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();

        DB::listen(function ($query) {

            // Log database queries that are longer than 100 milliseconds.
            if ($query->time > 100) {

                $queryDescription = '{'
                    . 'time: '
                    . $query->time
                    . ', '
                    . 'query:\"'
                    . $query->sql
                    . '\"'
                    . '}';


                Log::info($queryDescription, $query->bindings);
            }
        });
    }
}
