<?php

declare(strict_types=1);

namespace App\ValueObjects;

use App\Http\Requests\Api\WeatherRequest;

class Location
{
    public function __construct(
        public readonly float $lat,
        public readonly float $lon,
    ) {
    }

    public static function fromArray(array $array): self
    {
        return new self(
            lat: $array['lat'],
            lon: $array['lon']
        );
    }

    public static function fromWeatherApiRequest(WeatherRequest $request): self
    {
        return new self(
            lat: (float) $request->validated('lat'),
            lon: (float)  $request->validated('lon')
        );
    }

    public function toArray(): array
    {
        return [
            'lat' => $this->lat,
            'lon' => $this->lon,
        ];
    }
}
