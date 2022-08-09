<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Supoprt\Facades\Auth;

class UserController extends Controller
{
    public function edit(Request $request)
    {
        $this->validate($request, [
            'fullname' => ['string', 'max:100'],
            'nickname' => ['string', 'unique:users', 'max: 20'],
            'bio' => ['string', 'max:255'],
            'location' => ['string', 'max:50'],
            'url' => ['string', 'max:100'],
            'github' => ['string', 'max:50'],
            'email' => ['string', 'unique:users', 'max:100'],
            'phoneNumber' => ['string', 'unique:users', 'max:15'],
            'password' => ['string', 'min:8', 'max:255', 'confirmed'],
            'photo' => ['string'],
            'banner' => ['string'],
            'birthdate' => ['date', 'required']
        ]);

        $userId = Auth::user()->id;

        $user = User::find($userId);
        $user->fullname = $request->fullname;
        $user->nickname = $request->nickname;
        $user->bio = $request->bio;
        $user->location = $request->location;
        $user->url = $request->url;
        $user->github = $request->github;
        $user->email = $request->email;
        $user->phoneNumber = $request->phoneNumber;
        $user->password = Hash::make($request->password);
        $user->photo = $request->photo;
        $user->banner = $request->banner;
        $user->birthdate = $request->birthdate;
        $user->save();

        return response()->json(['status' => 'success', 'message' => 'Usuário atualizado com sucesso'], 202);
    }
}