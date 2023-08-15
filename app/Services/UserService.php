<?php

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{

    public function userLogin()
    {
        $credentials = request(['email', 'password']);
        $myTTL = 60 * 24 * 30; //minutes

        JWTAuth::factory()->setTTL($myTTL);

        if (!$token = auth()->guard('user-api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $token;
    }


    public function storeUser(UserRequest $request): User
    {
        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $admin;
    }


    public function getAllUsers()
    {
        return User::all();
    }

    public function updateUser(UserRequest $request, User $user)
    {
        $user->update($request->validated());
    }

    public function deleteUser(User $user)
    {
        $user->delete();
    }


}