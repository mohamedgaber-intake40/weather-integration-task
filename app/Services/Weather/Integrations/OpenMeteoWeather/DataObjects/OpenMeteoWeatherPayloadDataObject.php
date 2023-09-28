<?php

namespace App\Services\Weather\Integrations\OpenMeteoWeather\DataObjects;

use App\Services\Weather\Contracts\DataObjects\WeatherPayloadDataObject;
use Carbon\CarbonImmutable;

class OpenMeteoWeatherPayloadDataObject implements WeatherPayloadDataObject
{
    public function __construct(
        public readonly float $lat,
        public readonly float $lon,
        public readonly CarbonImmutable $date
    ) {
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            lat: $payload['lat'],
            lon: $payload['lon'],
            date: $payload['date'],
        );
    }

    public function toArray(): array
    {
        return [
            'latitude' => $this->lat,
            'longitude' => $this->lon,
            'start_date' => $this->date->toDateString(),
            'end_date' => $this->date->toDateString(),
            'daily' => 'apparent_temperature_max',
            'timezone' => config('services.weather.open_meteo_weather.timezone')
        ];
    }
}
