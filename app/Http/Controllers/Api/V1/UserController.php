<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Api\V1\Gender;
use App\Models\Api\V1\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user)
    {
        if (auth()->id() == $user->id) {
            $gender = Gender::find($user->gender_id);

            $data = [
                'id' => $user->id,
                'fio' => $user->fio,
                'email' => $user->email,
                'birthday' => $user->birthday,
                'gender' => [
                    'id' => $gender->id,
                    'name' => $gender->name
                ],
                'reviewCount' => $user->reviews()->count(),
                'ratingCount' => $user->ratings()->count()
            ];

            return response()->json($data);
        } else {
            return response([
                'message' => 'access denied'
            ]);
        }


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'fio' => ['required', 'min:2', 'max:150'],
            'email' => ['required', 'email', 'min:4', 'max:50', Rule::unique('users', 'email')],
            'birthday' => ['required', 'date'],
            'genderId' => ['required', Rule::exists('genders', 'id')]
        ]);

            $id = auth()->id();
            $user = User::find($id);
            $user->update($request->all());
            return response([
                'status' => "success"
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        auth()->user()->tokens()->delete();
        auth()->user()->delete();
        return response([
            "status" => 'success'
        ]);
    }
}
