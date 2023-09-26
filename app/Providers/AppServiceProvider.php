<?php

namespace App\Providers;

use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;
use PhpParser\Node\Expr\Instanceof_;

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
        Response::macro('jsonSuccess', function ($data, $status_code = Response::HTTP_OK, $message = 'success',) {
            $response = ['message' => $message];

            if ($data instanceof \Illuminate\Pagination\Paginator || 
                $data instanceof \Illuminate\Pagination\LengthAwarePaginator
            ){
                $response = array_merge($response, $data->toArray());
            } else {
                $response['data'] = $data;
            }

            return response()->json($response, $status_code);
        });
    }
}
