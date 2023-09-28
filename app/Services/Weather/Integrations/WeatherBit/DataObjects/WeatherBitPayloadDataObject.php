<?php

namespace App\Services\Weather\Integrations\WeatherBit\DataObjects;

use App\Services\Weather\Contracts\DataObjects\WeatherPayloadDataObject;
use Carbon\CarbonImmutable;

class WeatherBitPayloadDataObject implements WeatherPayloadDataObject
{
    public function __construct(
        public readonly float $lat,
        public readonly float $lon,
        public readonly CarbonImmutable $date,
        public readonly string $apiKey,
    ) {
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            lat: $payload['lat'],
            lon: $payload['lon'],
            date: $payload['date'],
            apiKey: config('services.weather.weather_bit.api_key')
        );
    }

    public function toArray(): array
    {
        return [
            'lat' => $this->lat,
            'lon' => $this->lon,
            'start_date' => $this->date->toDateString(),
            'end_date' => $this->date->addDay()->toDateString(),
            'key' => $this->apiKey,
        ];
    }
}
