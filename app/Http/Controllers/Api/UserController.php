<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use JWTAuth;
use JWTAuthException;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->user = new User;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = null;

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->api([
                    'message' => 'Invalid email or password',
                ], false);
            }
        } catch (JWTAuthException $e) {
            return response()->api([
                'message' => 'Failed to create token',
            ], false);
        }
        return response()->api([
            'token' => $token,
        ], true);
    }

    public function getAuthUser(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        return response()->api([
            'user' => $user
        ], true);
    }

}