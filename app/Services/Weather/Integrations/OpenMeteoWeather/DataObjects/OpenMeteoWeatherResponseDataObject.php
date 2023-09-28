<?php

namespace App\Services\Weather\Integrations\OpenMeteoWeather\DataObjects;

use App\Services\Weather\Contracts\DataObjects\WeatherResponseDataObject;

class OpenMeteoWeatherResponseDataObject implements WeatherResponseDataObject
{
    public function __construct(
        protected readonly float $temperature
    ) {
    }

    public static function fromArray(array $response)
    {
        return new self(
            temperature: (float) $response['daily']['apparent_temperature_max'][0]
        );
    }

    public function toArray(): array
    {
        return [
            'temperature' => $this->temperature,
        ];
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }
}
