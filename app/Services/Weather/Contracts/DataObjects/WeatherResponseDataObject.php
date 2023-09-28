<?php

declare(strict_types=1);

namespace App\Services\Weather\Contracts\DataObjects;

interface WeatherResponseDataObject
{
    public function toArray(): array;

    public function getTemperature(): float;
}
