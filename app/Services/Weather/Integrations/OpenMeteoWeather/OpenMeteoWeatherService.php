<?php

declare(strict_types=1);

namespace App\Services\Weather\Integrations\OpenMeteoWeather;

use App\Services\Weather\BaseWeatherService;
use App\Services\Weather\Contracts\DataObjects\WeatherPayloadDataObject;
use App\Services\Weather\Contracts\DataObjects\WeatherResponseDataObject;
use App\Services\Weather\Integrations\OpenMeteoWeather\DataObjects\OpenMeteoWeatherPayloadDataObject;
use App\Services\Weather\Integrations\OpenMeteoWeather\DataObjects\OpenMeteoWeatherResponseDataObject;
use App\ValueObjects\Location;
use Carbon\CarbonImmutable;

class OpenMeteoWeatherService extends BaseWeatherService
{
    public function isResponseValid(array $response): bool
    {
        return isset($response['daily']['apparent_temperature_max'][0]);
    }

    protected function requestPath(): string
    {
        return '/forecast';
    }

    protected function buildPayload(Location $location, CarbonImmutable $date): WeatherPayloadDataObject
    {
        return OpenMeteoWeatherPayloadDataObject::fromArray([
            'lat' => $location->lat,
            'lon' => $location->lon,
            'date' => $date,
        ]);
    }

    protected function buildResponse(array $response): WeatherResponseDataObject
    {
        return OpenMeteoWeatherResponseDataObject::fromArray($response);
    }
}
