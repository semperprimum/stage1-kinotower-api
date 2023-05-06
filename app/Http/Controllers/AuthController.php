<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Api\V1\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
           "fio" => ["required", "string", "min:2", "max:150"],
            "email" => ["required", "email", Rule::unique("users", "email"), "min:4", "max:50"],
            "password" => ["required", "string", "min:6", "max:200"],
            "birthday" => ["required", "date"],
            "genderId" => ["required", Rule::exists("genders", "id")]
        ]);

        $user = User::create([
           'fio' => $fields['fio'],
           'email' => $fields['email'],
           'password' => bcrypt($fields['password']),
            'birthday' => $fields['birthday'],
            'gender_id' => $fields['genderId']
        ]);

        $token = $user->createToken("token")->plainTextToken;

        $response = [
            "status" => "success",
            "token" => $token,
            "id" => $user->id,
            "fio" => $user->fio
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required", "string"],
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return \response([
                "status" => "invalid",
                "message" => "Wrong email or password"
            ], 401);
        }

        $token = $user->createToken("token")->plainTextToken;

        $response = [
            "status" => "success",
            "token" => $token,
            "id" => $user->id,
            "fio" => $user->fio
        ];

        return response($response, 201);
    }


    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            "status" => "success"
        ];
    }
}
