<?php


namespace App\Services;


use App\Http\Requests\GetAvgTemperatureRequest;
use App\Http\Requests\GetPopularTemperatureRequest;
use App\Models\Temperature;
use Illuminate\Support\Facades\DB;

final class WeatherService
{
    /**
     * @param string $city
     * @return array
     */
    public function getAvgTemperature(string $city): array
    {
        $temperature = Temperature::whereCity($city)->avg('temperature');

        return [
            'city'            => $city,
            'avg_temperature' => round($temperature, 2)
        ];
    }

    public function getPopularTemperature(GetPopularTemperatureRequest $request): array
    {
        $temperatureBuilder = DB::table('temperatures')
            ->selectRaw('SUM(asked) as sum_asked, city, date');

        if ($request->filled('city')) {
            $temperatureBuilder->where('city', $request->get('city'));
        }

        if ($request->filled('from_date')) {
            $temperatureBuilder->where('date', '>=', $request->get('from_date'));
        }

        $temperatureBuilder
            ->orderByRaw('sum_asked desc')
            ->groupBy('date')
            ->groupBy('city')
            ->havingRaw('sum_asked > ?', [$request->get('min_count')]);

        return $temperatureBuilder->get()->toArray();
    }
}
