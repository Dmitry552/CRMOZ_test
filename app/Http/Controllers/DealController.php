<?php

namespace App\Http\Controllers;

use App\Exceptions\BadRequestException;
use App\Http\Requests\CreateDealRequest;
use App\Http\Services\DealZohoService;
use Illuminate\Http\JsonResponse;

class DealController extends Controller
{
    private DealZohoService $service;

    public function __construct(DealZohoService $service)
    {
        $this->service = $service;
    }

    /**
     * @param CreateDealRequest $request
     * @return JsonResponse
     * @throws BadRequestException
     */
    public function createDeal(CreateDealRequest $request): JsonResponse
    {
        return $this->service->createDeal($request->all()['deal']);
    }
}
