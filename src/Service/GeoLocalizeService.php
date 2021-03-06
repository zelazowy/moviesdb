<?php declare(strict_types=1);

namespace App\Service;

use App\ValueObject\CountryValueObject;
use GuzzleHttp\Client;

class GeoLocalizeService
{
    private const API = "https://api.ip2country.info/ip?";

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

    public function getData(string $ip): string
    {
        $response = $this->getClient()->get(self::API . $ip);

        if (200 !== $response->getStatusCode()) {
            throw new \RuntimeException('Cannot connect to ip2country API');
        }

        return $response->getBody()->getContents();
    }

    public function byIP(string $ip): CountryValueObject
    {
        $country = json_decode($this->getData($ip));

        return new CountryValueObject($country->countryCode, $country->countryName, $country->countryEmoji);
    }
}
