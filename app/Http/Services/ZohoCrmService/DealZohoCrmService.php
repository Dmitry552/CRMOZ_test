<?php

namespace App\Http\Services\ZohoCrmService;

class DealZohoCrmService extends BaseZohoCrmService
{
    /**
     * @param string $moduleName
     * @return mixed
     */
    public function getFields(string $moduleName): mixed
    {
        return parent::getFields($moduleName);
    }

    /**
     * @param array $data
     * @return array|mixed
     */
    public function createDeal(array $data): mixed
    {
        $response = $this->query()->post('/v7/Deals', [
            'data' => [$data]
        ]);

        return $response->json();
    }
}
