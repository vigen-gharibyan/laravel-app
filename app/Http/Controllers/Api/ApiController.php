<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class ApiController extends Controller
{
    protected function response($data = [], $status = 200)
    {
        $body = [
            'success' => true,
            'statusCode' => $status,
            'data'   => $data,
        ];

        return response()->json($body, $status);
    }

}