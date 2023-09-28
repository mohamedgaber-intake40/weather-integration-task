<?php

declare(strict_types=1);

namespace App\Services\Weather\Contracts;

use App\Services\Weather\Contracts\DataObjects\WeatherResponseDataObject;
use App\ValueObjects\Location;
use Carbon\CarbonImmutable;

interface WeatherService
{
    public function getWeather(Location $location, CarbonImmutable $date): WeatherResponseDataObject;
}
