<?php

declare(strict_types=1);

namespace App\Services\Weather\Contracts\DataObjects;

interface WeatherPayloadDataObject
{
    public function toArray(): array;
}
