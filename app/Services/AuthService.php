<?php

namespace App\Services;

use App\Enums\TokenRole;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(string $email, string $password)
    {
        $user = $this->userRepository->getOne(['email' => $email]);
        if (empty($user)) {
            throw new HttpException(401, 'USER_NOT_FOUND');
        }

        $is_password_match = Hash::check($password, $user->password);
        if (! $is_password_match) {
            throw new HttpException(401, 'PASSWORD_NOT_MATCH');
        }

        $token = $user->createToken($user->email, [TokenRole::NORMAL])->plainTextToken;

        return [
            'token' => $token,
        ];
    }

    public function logout()
    {
        $user = $this->userRepository->find(Auth::id());
        $user->tokens()->delete();
    }

    public function getUserInfo()
    {
        $user = Auth::user();

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}
