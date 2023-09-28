<?php

namespace App\Services\Weather\Factory;

use App\Services\Weather\Contracts\WeatherService;
use App\Services\Weather\Integrations\OpenMeteoWeather\OpenMeteoWeatherService;
use App\Services\Weather\Integrations\WeatherBit\WeatherBitService;

class WeatherServiceFactory
{
    public static function make(): WeatherService
    {
        $weatherService = config('services.weather.service');
        $weatherServiceConfig = config('services.weather')[$weatherService];
        return app()->make($weatherServiceConfig['service_class'], ['baseUrl' => $weatherServiceConfig['base_url']]);
    }
}
