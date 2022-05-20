<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validate = $this->validate($request, [
            'nickname' => 'required|string',
            'password' => 'required|string'
        ]);

        if(!$token = Auth::attempt($validate)) {
            return response()->json(['status' => 'Unauthorized', 'message' => 'Usuário e/ou senha inválidos'], 401);
        }

        return $this->respondWithToken($token);
    }
}
