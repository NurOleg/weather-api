<?php


namespace App\Services\Weather;


use App\Interfaces\WeatherApi;
use App\Models\Temperature;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class MetaWeather implements WeatherApi
{
    /**
     * @param string $city
     * @return array
     * @throws \Throwable
     */
    public function getTemperature(string $city): array
    {
        $temperatureTodayBuilder = Temperature::where(['city' => $city, 'date' => Carbon::today(), 'source' => 'meta']);

        if ($temperatureTodayBuilder->exists()) {

            $todayTemperature = $temperatureTodayBuilder->first();
            $todayTemperature->asked = $todayTemperature->asked + 1;
            $todayTemperature->save();

            return [
                'city'        => $todayTemperature->city,
                'date'        => $todayTemperature->date,
                'asked'       => $todayTemperature->asked,
                'temperature' => $todayTemperature->temperature
            ];
        }

        $url = config('weather.meta.url');

        $response = Http::get($url . '/search', [
            'query' => $city
        ]);

        throw_if(empty($response->json()), new \Exception('No data for city'));

        $id = $response->json()[0]['woeid'];

        $response = Http::get($url . '/' . $id);

        throw_if(empty($response->json()), new \Exception('No weather for city'));

        $data = $response->json()['consolidated_weather'][0];

        $newTemperature = Temperature::create([
            'city'        => $city,
            'date'        => $data['applicable_date'],
            'asked'       => 1,
            'temperature' => $data['the_temp'],
            'source'      => 'meta',
        ]);

        return [
            'city'        => $newTemperature->city,
            'date'        => $newTemperature->date,
            'asked'       => $newTemperature->asked,
            'temperature' => $newTemperature->temperature
        ];
    }
}
