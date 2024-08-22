<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use App\Models\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserService
{
    private AuthService $service;
    private UserRepository $repository;

    public function __construct(AuthService $service, UserRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function createUser(array $data): array
    {
        /** @var User $user */
        $user = $this->repository->create([
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'email' => $data['email']
        ]);

        $user->zohoToken()->updateOrCreate(
            ['user_id' => $user->id],
            ['refresh_token' => $data['refresh_token']]
        );

        return $this->service->login($user);
    }

    public function loginForEmail(array $data): JsonResponse
    {
        /** @var User $user */
        $user = $this->repository->getUserForEmail($data['email']);

        $data = $this->service->login($user);

        if (isset($data['error'])) {
            response()->json($data, 401);
        }

        return response()->json($data);
    }

    public function getUser(): JsonResponse
    {
        return $this->service->me();
    }

    public function logoutUser(): JsonResponse
    {
        return $this->service->logout();
    }
}
