<?php

namespace App\Repositories;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
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
