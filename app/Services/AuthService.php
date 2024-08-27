<?php

namespace App\Services;

use App\Enums\TokenRole;
use App\Repositories\UserRepository;
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

        dd($user->createToken($user->email, [TokenRole::NORMAL]));
        $token = $user->createToken($user->email, [TokenRole::NORMAL])->plainTextToken;
        dd($token);

        return [
            'token' => $token,
        ];
    }
}
