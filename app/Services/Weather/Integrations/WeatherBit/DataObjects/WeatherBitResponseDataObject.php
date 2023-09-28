<?php

declare(strict_types=1);

namespace App\Services\Weather\Integrations\WeatherBit\DataObjects;

use App\Services\Weather\Contracts\DataObjects\WeatherResponseDataObject;

class WeatherBitResponseDataObject implements WeatherResponseDataObject
{
    public function __construct(
        protected readonly float $temperature
    ) {
    }

    public static function fromArray(array $response)
    {
        return new self(
            temperature: (float) $response['data'][0]['temp']
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
