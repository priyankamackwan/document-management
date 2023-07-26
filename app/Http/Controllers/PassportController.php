<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PassportController extends Controller
{
    public function register(Request $request) {

        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('Bearer')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    public function details()
    {
        return response()->json(['user' => auth()->user()], 200);
    }
}
