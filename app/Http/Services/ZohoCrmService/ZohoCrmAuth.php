<?php

namespace App\Http\Services\ZohoCrmService;

use App\Exceptions\BadRequestException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ZohoCrmAuth
{
    /**
     * @return string
     */
    public function getToken(): string
    {
        $response =  DB::table('zoho_access_tokens')
            ->select('token')
            ->first();

        if (!$response) {
            return $this->setToken();
        }

        return $response->token;
    }

    /**
     * @return string
     */
    public function setToken(): string
    {
        $token = $this->refreshToken();

        DB::table('zoho_access_tokens')
            ->limit(1)
            ->update([
                'token' => $token
            ]);

        return $token;
    }

    /**
     * @return mixed|void
     * @throws BadRequestException
     */
    public function refreshToken()
    {
        $refresh_token = env('ZOHO_REFRESH_TOKEN');
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
