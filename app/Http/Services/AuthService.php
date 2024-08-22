<?php

namespace App\Http\Services;

use App\Http\Resources\UserResource;
use App\Http\Services\ZohoCrmService\ZohoCrmAuth;
use App\Models\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    private ZohoCrmAuth $crmAuthService;
    private string $guard = 'user';

    public function __construct(ZohoCrmAuth $crmAuthService)
    {
        $this->crmAuthService = $crmAuthService;
    }

    public function login(User $data): array
    {
        $token = JWTAuth::fromUser($data);

        if (!$token) {
            return ['error' => 'Unauthorized'];
        }

        auth($this->guard)->login($data);
        $this->crmAuthService->setToken();

        return $this->respondWithToken($token);
    }

    public function logout(): JsonResponse
    {
        auth($this->guard)->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me(): JsonResponse
    {
        return response()->json(new UserResource(auth($this->guard)->user()));
    }

    private function respondWithToken(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth($this->guard)->factory()->getTTL() * 60
        ];
    }
}
