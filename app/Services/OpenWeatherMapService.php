<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use Illuminate\Support\Carbon;

class OpenWeatherMapService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => config('openweathermap.base_url')]);
        $this->apiKey = config('openweathermap.api_key');
    }

    public function getCurrentWeather($city, $country, $units = 'metric')
    {
        try {
            $response = $this->client->get('weather', [
                'query' => [
                    'q' => "$city,$country",
                    'units' => $units,
                    'appid' => $this->apiKey,
                ]
            ]);
            return json_decode($response->getBody(), true);
        } catch (\Throwable $th) {
            return [
                'code' => $th->getResponse()->getStatusCode(),
                'message' => $th->getResponse()->getReasonPhrase()
            ];
        }
    }

    public function getForecast($city, $country, $days = 1, $units = 'metric')
    {
        try {
            $response = $this->client->get('forecast/daily', [
                'query' => [
                    'q' => "$city,$country",
                    'cnt' => $days,
                    'units' => $units,
                    'appid' => $this->apiKey,
                ]
            ]);
    
            return json_decode($response->getBody(), true);
        } catch (\Throwable $th) {
            return [
                'code' => $th->getResponse()->getStatusCode(),
                'message' => $th->getResponse()->getReasonPhrase()
            ];
        }
        
    }
}
