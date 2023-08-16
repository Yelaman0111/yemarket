<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\UserRequest;
use App\Models\User;

interface UserRepositoryInterface
{
    public function storeUser(UserRequest $request): User;

    public function getAllUsers();

    public function updateUser(UserRequest $request, User $user);

    public function deleteUser(User $user);


}