<?php

namespace App\Http\Services;

use App\Exceptions\BadRequestException;
use App\Http\Services\ZohoCrmService\DealZohoCrmService;
use Illuminate\Http\JsonResponse;

class DealZohoService
{
    private DealZohoCrmService $dealService;

    public function __construct(DealZohoCrmService $dealService)
    {
        $this->dealService = $dealService;
    }

    /**
     * @param array $data
     * @return JsonResponse
     * @throws BadRequestException
     */
    public function createDeal(array $data): JsonResponse
    {
        $deal = $this->dealService->createDeal($data);

        if ($deal['data'][0]['status'] !== 'success') {
            throw new BadRequestException('Deal not created');
        }

        return response()->json(['status' => 'success']);
    }
}
