<?php


namespace App\Services\Weather;


use App\Interfaces\WeatherApi;

class EmptyWeather implements WeatherApi
{
    /**
     * @param string $city
     * @return array
     */
    public function getTemperature(string $city): array
    {
        return [];
    }
}
