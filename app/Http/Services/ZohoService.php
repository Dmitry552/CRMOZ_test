<?php

namespace App\Http\Services;

use App\Exceptions\BadRequestException;
use App\Http\Services\ZohoCrmService\AccountZohoCrmService;
use App\Http\Services\ZohoCrmService\DealZohoCrmService;
use Illuminate\Http\JsonResponse;

class ZohoService
{
    private AccountZohoCrmService $accountService;
    private DealZohoCrmService $dealService;

    public function __construct(
        AccountZohoCrmService $accountService,
        DealZohoCrmService $dealService
    ) {
        $this->dealService = $dealService;
        $this->accountService = $accountService;
    }

    /**
     * @param array $data
     * @return JsonResponse
     * @throws BadRequestException
     */
    public function createAccountAndDeal(array $data): JsonResponse
    {
        $accountData = $data['account'];
        $dealData = $data['deal'];

        $account = $this->accountService->createAccount($accountData);

        if ($account['data'][0]['status'] !== 'success') {
            throw new BadRequestException('Account not created');
        }

        $dealData['Account_Name'] = $account['data'][0]['details']['id'];
        $dealData = $this->dealService->createDeal($dealData);

        if ($dealData['data'][0]['status'] !== 'success') {
            throw new BadRequestException('Deal not created');
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function getRequiredFields(array $data): JsonResponse
    {
        $filter = null;

        if (isset($data['fields'])) {
            $filter = json_decode($data['fields']);
        }

        $accountsFields = $this->accountService->getAccountFields();
        $dealsFields = $this->dealService->getDealFields();

        $filteredAccounts = $this->filterFieldsForRequired(
            $accountsFields,
            'account',
            $filter
        );
        $filteredDeals = $this->filterFieldsForRequired(
            $dealsFields,
            'deal',
            $filter
        );

        return response()->json(array_merge($filteredAccounts, $filteredDeals));
    }

    /**
     * @param array $data
     * @param string $key
     * @param object|null $filter
     * @return array[]
     */
    private function filterFieldsForRequired(array $data, string $key, object|null $filter = null): array
    {
        $results = [];

        foreach ($data as $item) {
            if ($item['system_mandatory'] || in_array($item['api_name'], $filter->$key)) {
                $results[] = $item;
            }
        }

        return [$key => $results];
    }
}
