<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccountAndDealRequest;
use App\Http\Requests\GetRequiredFieldsRequest;
use App\Http\Services\ZohoService;
use Illuminate\Http\JsonResponse;

class ZohoController extends Controller
{
    private ZohoService $service;

    public function __construct(ZohoService $service)
    {
        $this->service = $service;
    }

    public function createAccountAndDeal(CreateAccountAndDealRequest $request): JsonResponse
    {
        return $this->service->createAccountAndDeal($request->all());
    }

    public function getRequiredFields(GetRequiredFieldsRequest $request): JsonResponse
    {
        return $this->service->getRequiredFields($request->all());
    }
}
