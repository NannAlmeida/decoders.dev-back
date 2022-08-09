<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

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

    public function register(Request $request)
    {
        $this->validate($request, [
            'fullname' => ['string', 'required', 'max:100'],
            'nickname' => ['string', 'required', 'unique:users', 'max: 20'],
            'bio' => ['string', 'max:255'],
            'location' => ['string', 'max:50'],
            'url' => ['string', 'max:100'],
            'github' => ['string', 'max:50'],
            'email' => ['string', 'required', 'unique:users', 'max:100'],
            'phoneNumber' => ['string', 'unique:users', 'max:15'],
            'password' => ['string', 'min:8', 'max:255', 'required', 'confirmed'],
            'photo' => ['string'],
            'banner' => ['string'],
            'birthdate' => ['date', 'required']
        ]);

        $fullname = $request->fullname;
        $nickname = $request->nickname;
        $bio = $request->bio ?: "";
        $location = $request->location ?: "";
        $url = $request->url ?: "";
        $github = $request->github ?: "";
        $email = $request->email;
        $phoneNumber = $request->phoneNumber ?: "";
        $password = Hash::make($request->password);
        $photo = $request->photo ?: "";
        $banner = $request->banner ?: "";
        $birthdate = $request->birthdate;

        try {
            $user = new User();
            $user->id = Uuid::uuid6();
            $user->fullname = $fullname;
            $user->nickname = $nickname;
            $user->bio = $bio;
            $user->location = $location;
            $user->url = $url;
            $user->github = $github;
            $user->email = $email;
            $user->phoneNumber = $phoneNumber;
            $user->password = $password;
            $user->photo = $photo;
            $user->banner = $banner;
            $user->birthdate = $birthdate;
            $user->save();

            $token = Auth::attempt($request->only(['nickname', 'password']));

            return $token ? $this->respondWithToken($token) : response()->json(['status' => 'Created', 'user' => $user], 201);
        }catch (\Exception $error) {
            echo "<pre>";
            var_dump($error);
            exit();
            return response()->json(['status' => 'Error', 'message' => 'Erro ao criar o Usuário'], 409);
        }
    }
}
