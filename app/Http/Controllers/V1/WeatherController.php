<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\OpenWeatherMapService;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(OpenWeatherMapService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function getCurrentWeather(Request $request)
    {
        $location = $request->input('location', 'Santander,ES');
        [$city, $country] = explode(',', $location);
        $units = $request->input('units', 'metric');
        $weather = $this->weatherService->getCurrentWeather($city, $country, $units);

        return response()->json($weather);
    }

    public function getForecast(Request $request)
    {
        $location = $request->input('location', 'Santander,ES');
        [$city, $country] = explode(',', $location);
        $days = $request->input('days', 1);
        $units = $request->input('units', 'metric');
        $forecast = $this->weatherService->getForecast($city, $country, $days, $units);

        return response()->json($forecast);
    }
}
