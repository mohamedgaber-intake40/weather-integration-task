<?php

declare(strict_types=1);

namespace App\Services\Weather\Integrations\WeatherBit;

use App\Services\Weather\BaseWeatherService;
use App\Services\Weather\Contracts\DataObjects\WeatherPayloadDataObject;
use App\Services\Weather\Contracts\DataObjects\WeatherResponseDataObject;
use App\Services\Weather\Integrations\WeatherBit\DataObjects\WeatherBitPayloadDataObject;
use App\Services\Weather\Integrations\WeatherBit\DataObjects\WeatherBitResponseDataObject;
use App\ValueObjects\Location;
use Carbon\CarbonImmutable;

class WeatherBitService extends BaseWeatherService
{
    public function isResponseValid(array $response): bool
    {
        return isset($response['data']);
    }

    protected function requestPath(): string
    {
        return '/history/daily';
    }

    protected function buildPayload(Location $location, CarbonImmutable $date): WeatherPayloadDataObject
    {
        return WeatherBitPayloadDataObject::fromArray(
            payload : [
                'lat' => $location->lat,
                'lon' => $location->lon,
                'date' => $date,
            ]
        );
    }

    protected function buildResponse(array $response): WeatherResponseDataObject
    {
        return WeatherBitResponseDataObject::fromArray(
            response: $response
        );
    }
}
