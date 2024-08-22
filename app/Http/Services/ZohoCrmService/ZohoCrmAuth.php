<?php

namespace App\Http\Services\ZohoCrmService;

use App\Exceptions\BadRequestException;
use App\Models\ZohoToken;
use Illuminate\Support\Facades\Http;

class ZohoCrmAuth
{
    /**
     * @return string
     * @throws BadRequestException
     */
    public function getToken(): string
    {
        $zohoToken = auth('user')->user()->zohoToken;

        if (!$zohoToken->access_token) {
            return $this->setToken();
        }

        return $zohoToken->access_token;
    }

    /**
     * @return string
     * @throws BadRequestException
     */
    public function setToken(): string
    {
        /** @var ZohoToken $zohoToken */
        $zohoToken = auth('user')->user()->zohoToken;

        $token = $this->refreshToken($zohoToken->refresh_token);

        $zohoToken->update([
            'access_token' => $token
        ]);

        return $token;
    }

    /**
     * @return mixed|void
     * @throws BadRequestException
     */
    public function refreshToken(string $refresh_token)
    {
        $client_id = env('ZOHO_CLIENT_ID');
        $client_secret = env('ZOHO_CLIENT_SECRET');

        try {
            $response = Http::retry(3, 100)->withQueryParameters([
                'grant_type' => 'refresh_token',
                'refresh_token' => $refresh_token,
                'client_id' => $client_id,
                'client_secret' => $client_secret
            ])->post('https://accounts.zoho.eu/oauth/v2/token');

            return $response->json()['access_token'];
        } catch (\Throwable $error) {
            throw new BadRequestException();
        }
    }
}
