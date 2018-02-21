<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory;

class ResponseServiceProvider extends ServiceProvider
{
    public function boot(ResponseFactory $factory)
    {
        $factory->macro('api', function ($data, $success, $statusCode=200) use ($factory) {
            $customFormat = [
                'success' => $success,
                'statusCode' => $statusCode,
                'data' => $data,
            ];
            return $factory->make($customFormat, $statusCode);
        });
    }

    public function register()
    {
        //
    }
}