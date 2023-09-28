<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WeatherRequest;
use App\Http\Resources\WeatherResource;
use App\Services\Weather\Contracts\WeatherService;
use App\ValueObjects\Location;
use Carbon\CarbonImmutable;

class WeatherController extends Controller
{
    public function __construct(
        private readonly WeatherService $weatherService
    ) {
    }

    public function __invoke(WeatherRequest $request)
    {
        return apiResponse()
            ->success()
            ->data(
                WeatherResource::make(
                    $this->weatherService->getWeather(
                        location: Location::fromWeatherApiRequest($request),
                        date: CarbonImmutable::make($request->validated('date'))
                    )
                )
            )
            ->send();
    }
}
