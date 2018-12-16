<?php declare(strict_types=1);

namespace App\Service;

use GuzzleHttp\Client;

class AvatarService
{
    private const API_URL = "https://api.adorable.io/avatars/64/";

    /**
     * @var Client
     */
    private $client = null;

    private function getClient(): Client
    {
        if (null === $this->client) {
            $this->client = new Client();
        }

        return $this->client;
    }
    
    public function getForEmail(string $email): string
    {
        $avatarUrl = self::API_URL . $email;
        $response = $this->getClient()->get($avatarUrl);

        if (200 !== $response->getStatusCode()) {
            throw new \RuntimeException('There is some issue with avatar api');
        }

        return $avatarUrl;
    }
}
