<?php


namespace App\Interfaces;


interface WeatherApi
{
    public function getTemperature(string $city): array;
}
