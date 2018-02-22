<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use JWTAuth;
use JWTAuthException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => [
                'create',
                'login',
            ]
        ]);

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

    public function register(Request $request)
    {
        event(new Registered($user = $this->create($request->all())));

        return response()->api($user, true);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getAuthUser(Request $request)
    {
        $user = JWTAuth::toUser($request->token);

        return response()->api($user, true);
    }

}