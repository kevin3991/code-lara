<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        try {
            $params = $request->validated();
            $response = $this->authService->login($params['email'], $params['password']);

            return $this->responseSuccess('Login successfully', [
                'token' => $response['token'],
            ]);
        } catch (\Throwable $th) {
            return $this->responseUnAuthenticated($th->getMessage());
        }
    }
}
