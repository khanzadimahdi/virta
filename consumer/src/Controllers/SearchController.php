<?php

namespace App\Controllers;

use Exception;
use GuzzleHttp\Client;

class SearchController
{
    const APIURL = 'web:80';

    public function search(float $latitude, float $longitude, ?float $distance = null): array
    {
        $response = [];

        try {
            $response = $this->fetch($latitude, $longitude, $distance);
        } catch (Exception $exception) {
            // we cant store $exception in log or somewhere

            throw new Exception('can\'t fetch data:' . $exception->getMessage());
        }

        return $response;
    }

    protected function fetch(float $latitude, float $longitude, ?float $distance = null): array
    {
        $uri = sprintf('%s/%s', self::APIURL, 'api/v1/stations/search');

        $client = new Client();

        $data = [
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];

        if (!is_null($distance)) {
            $data['distance'] = $distance;
        }

        $response = $client->request('GET', $uri, [
            'json' => $data,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
