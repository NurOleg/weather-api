<?php


namespace App\Resolvers;

use App\Services\Weather\MetaWeather;
use App\Services\Weather\OnlineWeather;

class WeatherSourceResolver
{
    protected string $name;

    public const SOURCE_MAPPING = [
        'meta'     => MetaWeather::class,
        'online' => OnlineWeather::class,
    ];

    public function __construct(string $className)
    {
        $this->name = $className;
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function resolveDependencyName(): string
    {
        throw_unless(isset(self::SOURCE_MAPPING[$this->name]), new \Exception('Weather source does not exists.'));

        return self::SOURCE_MAPPING[$this->name];
    }
}
