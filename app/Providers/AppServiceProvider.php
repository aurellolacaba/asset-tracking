<?php

namespace App\Providers;

use Illuminate\Http\Response;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('jsonSuccess', function ($data, $status_code = Response::HTTP_OK) {
            return response()->json([
                'message' => 'success',
                'data' => $data
            ], $status_code);
        });
    }
}
