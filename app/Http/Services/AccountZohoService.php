<?php

namespace App\Http\Services;

use App\Exceptions\BadRequestException;
use App\Http\Services\ZohoCrmService\AccountZohoCrmService;
use Illuminate\Http\JsonResponse;

class AccountZohoService
{
    private AccountZohoCrmService $accountService;

    public function __construct(AccountZohoCrmService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * @param array $data
     * @return JsonResponse
     * @throws BadRequestException
     */
    public function createAccount(array $data): JsonResponse
    {
        $account = $this->accountService->createAccount($data);

        if ($account['data'][0]['status'] !== 'success') {
            throw new BadRequestException('Account not created');
        }

        return response()->json(['status' => 'success']);
    }
}
