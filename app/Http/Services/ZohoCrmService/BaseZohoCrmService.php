<?php

namespace App\Http\Services\ZohoCrmService;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

abstract class BaseZohoCrmService
{
    const BASEURL = "https://www.zohoapis.eu/crm";

    private string $accessToken;
    private PendingRequest $query;
    private ZohoCrmAuth $auth;

    public function __construct(ZohoCrmAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param string $url
     * @param array $data
     * @return PromiseInterface|Response
     */
    protected function post(
        string $url,
        array $data = [],
    ): PromiseInterface|Response {
        $response = $this->query->post(self::BASEURL.$url, $data);

        if ($response->status() === 401) {
            $this->accessToken = $this->auth->setToken();
            $response = $this->post($url, $data);
        }

        return $response;
    }

    /**
     * @param string $url
     * @param array $data
     * @return PromiseInterface|Response
     */
    protected function get(
        string $url,
        array $data = [],
    ): PromiseInterface|Response {
        $response = $this->query->get(self::BASEURL.$url, $data);

        if ($response->status() === 401) {
            $this->accessToken = $this->auth->setToken();
            $response = $this->get($url, $data);
        }

        return $response;
    }

    /**
     * @param array|null $headers
     * @param array|null $params
     * @return $this
     */
    protected function query(
        array|null $headers = null,
        array|null $params = null
    ): self {
        $this->accessToken = $this->auth->getToken();

        $baseHeaders = [
            'Authorization' => 'Zoho-oauthtoken ' . $this->accessToken
        ];

        if ($headers) {
            $baseHeaders = array_merge($baseHeaders, $headers);
        }

        $query = Http::withHeaders($baseHeaders);

        if ($params) {
            $query->withQueryParameters($params);
        }

        $this->query = $query;

        return $this;
    }

    /**
     * @param string $moduleName
     * @return mixed
     */
    protected function getRequiredFields(string $moduleName)
    {
        $moduleName = ucfirst($moduleName);

        $response = $this->query(null, [
            'module' => $moduleName
        ])->get('/v7/settings/fields');

        return $response->json()['fields'];
    }
}
