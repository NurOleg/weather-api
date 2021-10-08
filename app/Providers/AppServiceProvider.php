<?php

namespace App\Providers;

use App\Interfaces\WeatherApi;
use App\Resolvers\WeatherSourceResolver;
use App\Services\Weather\EmptyWeather;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @throws \Throwable
     */
    public function register()
    {
        $className = request()->filled('source') ? $this->resolveClassName(request()->get('source')) : EmptyWeather::class;

        $this->app->bind(WeatherApi::class, $className);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * @param string $className
     * @return string
     * @throws \Throwable
     */
    protected function resolveClassName(string $className): string
    {
        $resolver = new WeatherSourceResolver($className);
        $className = $resolver->resolveDependencyName();
        return $className;
    }
}
