<?php

namespace App\Http\Services\ZohoCrmService;

class AccountZohoCrmService extends BaseZohoCrmService
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
    public function createAccount(array $data): mixed
    {
        $response = $this->query()->post('/v7/Accounts', [
            'data' => [$data]
        ]);

        return $response->json();
    }
}
