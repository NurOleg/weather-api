<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAvgTemperatureRequest;
use App\Http\Requests\GetPopularTemperatureRequest;
use App\Http\Requests\GetTemperatureRequest;
use App\Interfaces\WeatherApi;
use App\Services\WeatherService;

class TemperatureController extends Controller
{
    private WeatherApi $weatherApi;

    public function __construct(WeatherApi $weatherApi)
    {
        $this->weatherApi = $weatherApi;
    }

    /**
     * @param GetTemperatureRequest $request
     * @return array
     */
    public function getTemperature(GetTemperatureRequest $request): array
    {
        return $this->weatherApi->getTemperature($request->get('city'));
    }

    /**
     * @param GetAvgTemperatureRequest $request
     * @return array
     */
    public function getAvgTemperature(GetAvgTemperatureRequest $request): array
    {
        return app(WeatherService::class)->getAvgTemperature($request->get('city'));
    }

    /**
     * @param GetPopularTemperatureRequest $request
     * @return array
     */
    public function getPopularTemperature(GetPopularTemperatureRequest $request): array
    {
        return app(WeatherService::class)->getPopularTemperature($request);
    }
}
