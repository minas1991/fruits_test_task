<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class FetchFruitsService
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $apiEndpoint
    ) {
    }

    /**
     * @return array
     */
    public function fetchAllFruits(): array
    {
        return $this->sendRequest('/fruit/all');
    }

    /**
     * @param int|string $id
     * @return array
     */
    public function fetchFruit(int|string $id): array
    {
        return $this->sendRequest('/fruit/' . $id);
    }

    /**
     * @param string $url
     * @param string $method
     * @return array
     */
    private function sendRequest(string $url, string $method = 'GET'): array
    {
        $response = $this->client->request(
            $method,
            rtrim($this->apiEndpoint, '/') . '/' . ltrim($url, '/')
        );

        return $response->toArray();
    }
}
