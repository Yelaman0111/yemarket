<?php

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Models\Company;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

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
        return $this->userRepository->storeUser($request);
    }


    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

    public function updateUser(UserRequest $request, User $user)
    {
        $this->userRepository->updateUser($request, $user);
    }

    public function deleteUser(User $user)
    {
        $this->userRepository->deleteUser($user);
    }
}
