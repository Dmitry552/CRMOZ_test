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
    public function createModules(array $data): JsonResponse
    {
        $accountData = $data['account'];
        $dealData = $data['deal'];

        $account = $this->accountService->createAccount($accountData);

        if ($account['data'][0]['status'] !== 'success') {
            throw new BadRequestException('Account not created');
        }

        if (isset($data['link']) && $data['link']) {
            $dealData['Account_Name'] = $account['data'][0]['details']['id'];
        }

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
        $filteredData = [];

        if (isset($data['fields'])) {
            $filter = json_decode($data['fields']);
        }

        foreach ($filter as $key => $value) {
            $service = $key."Service";

            $fields = $this->$service->getFields(ucfirst($key)."s");

            $filtered = $this->filterFieldsForRequired(
                $fields,
                $key,
                $value
            );

            $filteredData = array_merge($filteredData,  $filtered);
        }

        return response()->json($filteredData);
    }

    /**
     * @param array $data
     * @param string $key
     * @param array|null $filter
     * @return array[]
     */
    private function filterFieldsForRequired(array $data, string $key, array|null $filter = null): array
    {
        $results = [];

        foreach ($data as $item) {
            if ($item['system_mandatory'] || in_array($item['api_name'], $filter)) {
                $results[] = $item;
            }
        }

        return [$key => $results];
    }
}
