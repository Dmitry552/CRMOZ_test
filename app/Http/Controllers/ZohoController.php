<?php

namespace App\Http\Controllers;

use App\Exceptions\BadRequestException;
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

    /**
     * @param CreateAccountAndDealRequest $request
     * @return JsonResponse
     * @throws BadRequestException
     */
    public function createModules(CreateAccountAndDealRequest $request): JsonResponse
    {
        return $this->service->createModules($request->all());
    }

    /**
     * @param GetRequiredFieldsRequest $request
     * @return JsonResponse
     */
    public function getRequiredFields(GetRequiredFieldsRequest $request): JsonResponse
    {
        return $this->service->getRequiredFields($request->all());
    }
}
