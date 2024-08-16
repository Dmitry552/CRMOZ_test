<?php

namespace App\Http\Controllers;

use App\Exceptions\BadRequestException;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Services\AccountZohoService;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    private AccountZohoService $service;

    public function __construct(AccountZohoService $service)
    {
        $this->service = $service;
    }

    /**
     * @param CreateAccountRequest $request
     * @return JsonResponse
     * @throws BadRequestException
     */
    public function createAccount(CreateAccountRequest $request): JsonResponse
    {
        return $this->service->createAccount($request->all()['account']);
    }
}
