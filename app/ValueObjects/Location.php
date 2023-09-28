<?php

namespace App\ValueObjects;

use App\Http\Requests\Api\WeatherRequest;

class Location
{
    public function __construct(
        public readonly float $lat,
        public readonly float $lon,
    ) {
    }

    public function toArray(): array
    {
        return [
            'lat' => $this->lat,
            'lon' => $this->lon,
        ];
    }

    public static function fromArray(array $array): self
    {
        return new self(
            lat: $array['lat'],
            lon: $array['lon']
        );
    }

    public static function fromWeatherApiRequest(WeatherRequest $request) : self
    {
        return new self(
            lat: $request->validated('lat'),
            lon: $request->validated('lon')
        );
    }


}
