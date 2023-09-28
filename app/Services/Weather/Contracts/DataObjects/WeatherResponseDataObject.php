<?php

namespace App\Services\Weather\Contracts\DataObjects;

interface WeatherResponseDataObject
{
    public function toArray() : array;

    public function getTemperature(): float;
}
