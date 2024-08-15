<?php

namespace App\Http\Services\ZohoCrmService;

class AccountZohoCrmService extends BaseZohoCrmService
{
    /**
     * @param array $data
     * @return array|mixed
     */
    public function createAccount(array $data)
    {
        $response = $this->query()->post('/v7/Accounts', [
            'data' => [$data]
        ]);

        return $response->json();
    }

    public function getAccountFields()
    {
        return parent::getRequiredFields('Accounts');
    }
}
