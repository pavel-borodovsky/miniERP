<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        if(!isset($request['email']) || !isset($request['password'])) {
            return response('Access denied', 400);
        }
        $login = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($login)
        if (!Auth::attempt($login)){
            return response(['message' => 'Неверные логин и пароль']);
        }
        $user = User::find(1);
        $token = $user->createToken('authToken')->accessToken;
        return response([
            'user' => Auth::user(),
            'access_token' => $token
        ]);
    }
}
