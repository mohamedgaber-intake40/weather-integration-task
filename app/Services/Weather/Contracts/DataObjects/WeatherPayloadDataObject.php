<?php

namespace App\Services\Weather\Contracts\DataObjects;

interface WeatherPayloadDataObject
{
    public function toArray(): array;
}
