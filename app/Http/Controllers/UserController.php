<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\DatabaseManager;
use Illuminate\Events\Dispatcher;
//use App\Services\UserService;
use App\User;

class UserController extends Controller
{
    /*
    private $userService;
    */
    private $dispatcher;

    public function __construct(
    //  UserService $userService
        DatabaseManager $database,
        Dispatcher $dispatcher
    ) {
    //  $this->userService = $userService;
        $this->database = $database;
        $this->dispatcher = $dispatcher;
    }

    public function create(Request $request)
    {
        /*
        $validatedData = $request->validate([
            'name' => 'required|unique:users|max:30',
            'email' => 'required|unique:users|email',
            'password' => 'required',
        ]);
        */

    //    $user = $this->userService->create($request->get('user'));

        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => self::hash($request->get('password'))
        ]);

    //    $this->dispatcher->fire(new UserWasCreated($user));

        $user->save();
        return response()->json([
            $user,
            'message' => 'Successfully added'
        ], 201);
    }

    public function authenticate(Request $request)
    {
        $user = User::where('name', $request->get('name'))->first();

        if(self::hash($request->get('password')) == $user->password) {
            return response()->json([
                'user' => $user,
                'message' => 'Login Successfull'
            ]);
        }

        return response()->json([
            'message' => 'Failed'
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
    //  $user->password = $request->get('password');

        $user->save();
        return response()->json([
            'message' => 'Successfully updated'
        ]);
    }

    public function checkEmail(Request $request, $email)
    {
        $user = User::where('email', $email)->first();

        if(empty($user)) {

        }

        $user->save();
        return response()->json([
            'message' => 'Successfully updated'
        ]);
    }

    private static function hash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

}
