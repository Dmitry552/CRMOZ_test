<?php

namespace App\Http\Services\ZohoCrmService;

class DealZohoCrmService extends BaseZohoCrmService
{
    /**
     * @param array $data
     * @return array|mixed
     */
    public function createDeal(array $data)
    {
        $response = $this->query()->post('/v7/Deals', [
            'data' => [$data]
        ]);

        return $response->json();
    }

    public function getDealFields()
    {
        return parent::getRequiredFields('Deals');
    }
}
