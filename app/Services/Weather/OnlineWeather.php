<?php


namespace App\Services\Weather;


use App\Interfaces\WeatherApi;
use App\Models\Temperature;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class OnlineWeather implements WeatherApi
{
    /**
     * @param string $city
     * @return array
     * @throws \Throwable
     */
    public function getTemperature(string $city): array
    {
        $temperatureTodayBuilder = Temperature::where(['city' => $city, 'date' => Carbon::today(), 'source' => 'online']);

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

        $url = config('weather.online.url');

        $response = Http::get($url, [
            'q'           => $city,
            'num_of_days' => 1,
            'key'         => config('weather.online.key'),
            'format'      => 'json',
        ]);

        throw_if(isset($response->json()['data']['error']), new \Exception('No data for city'));

        $data = $response->json()['data']['weather'][0];

        $newTemperature = Temperature::create([
            'city'        => $city,
            'date'        => $data['date'],
            'asked'       => 1,
            'temperature' => $data['avgtempC'],
            'source'      => 'online',
        ]);

        return [
            'city'        => $newTemperature->city,
            'date'        => $newTemperature->date,
            'asked'       => $newTemperature->asked,
            'temperature' => $newTemperature->temperature
        ];
    }
}
