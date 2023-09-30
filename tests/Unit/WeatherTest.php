<?php

use App\Services\Weather\Contracts\DataObjects\WeatherResponseDataObject;
use App\Services\Weather\Exceptions\InvalidWeatherResponse;
use App\Services\Weather\Factory\WeatherServiceFactory;
use App\Services\Weather\Integrations\OpenMeteoWeather\DataObjects\OpenMeteoWeatherResponseDataObject;
use App\Services\Weather\Integrations\WeatherBit\DataObjects\WeatherBitResponseDataObject;
use App\ValueObjects\Location;
use Carbon\CarbonImmutable;

it('test weather service factory returns the correct concert weather class depend on configuration', function ($weatherService) {
    config([ 'services.weather.service' => $weatherService ]);
    $weatherServiceConfigurations = config('services.weather')[ $weatherService ];
    $weatherClass = WeatherServiceFactory::make();
    expect($weatherClass)->toBeInstanceOf($weatherServiceConfigurations['service_class']);
})->with([
    'weather_bit',
    'open_meteo_weather'
]);

it('test open meteo weather service returns valid temperature response', function () {
    $temperatureValue = fake()->randomFloat();
    Http::fake([
        config('services.weather.open_meteo_weather.base_url').'*'  => Http::response([ 'daily' => [ 'apparent_temperature_max' => [ $temperatureValue ] ] ]),
    ]);
    config([ 'services.weather.service' => 'open_meteo_weather' ]);
    $temperatureResponse = WeatherServiceFactory::make()->getWeather(
        Location::fromArray([
            'lat' => fake()->latitude(),
            'lon' => fake()->longitude(),
        ]),
        CarbonImmutable::make(fake()->date())
    );
    expect($temperatureResponse)
        ->toBeInstanceOf(WeatherResponseDataObject::class)
        ->toBeInstanceOf(OpenMeteoWeatherResponseDataObject::class)
        ->and($temperatureResponse->getTemperature())->toEqual($temperatureValue);
})->repeat(100);

it('test open meteo weather service throw an InvalidWeatherResponse exception when invalid service response even if response status code is 200  ', function () {
    Http::fake([
        config('services.weather.open_meteo_weather.base_url').'*'  => Http::response([ 'missing required key']),
    ]);
    config([ 'services.weather.service' => 'open_meteo_weather' ]);
     WeatherServiceFactory::make()->getWeather(
        Location::fromArray([
            'lat' => fake()->latitude(),
            'lon' => fake()->longitude(),
        ]),
        CarbonImmutable::make(fake()->date())
    );
})->throws(InvalidWeatherResponse::class);

it('test open meteo weather service throw an InvalidWeatherResponse exception when invalid service response and response status code is not 200  ', function () {
    Http::fake([
        config('services.weather.open_meteo_weather.base_url').'*'  => Http::response([ Str::random()],fake()->numberBetween(400,404)),
    ]);
    config([ 'services.weather.service' => 'open_meteo_weather' ]);
    WeatherServiceFactory::make()->getWeather(
        Location::fromArray([
            'lat' => fake()->latitude(),
            'lon' => fake()->longitude(),
        ]),
        CarbonImmutable::make(fake()->date())
    );
})->repeat(5)->throws(InvalidWeatherResponse::class);


it('test  weather bit service returns valid temperature response', function () {
    $temperatureValue = fake()->randomFloat();
    Http::fake([
        config('services.weather.weather_bit.base_url').'*' => Http::response([ 'data' => [ [ 'temp' => $temperatureValue ] ] ]),
    ]);
    config([ 'services.weather.service' => 'weather_bit' ]);
    $temperatureResponse = WeatherServiceFactory::make()->getWeather(
        Location::fromArray([
            'lat' => fake()->latitude(),
            'lon' => fake()->longitude(),
        ]),
        CarbonImmutable::make(fake()->date())
    );
    expect($temperatureResponse)
        ->toBeInstanceOf(WeatherResponseDataObject::class)
        ->toBeInstanceOf(WeatherBitResponseDataObject::class)
        ->and($temperatureResponse->getTemperature())->toEqual($temperatureValue);
})->repeat(100);

it('test weather bit weather service throw an InvalidWeatherResponse exception when invalid service response even if response status code is 200  ', function () {
    Http::fake([
          config('services.weather.weather_bit.base_url').'*'  => Http::response([ 'missing required key']),
    ]);
    config([ 'services.weather.service' => 'weather_bit' ]);
    WeatherServiceFactory::make()->getWeather(
        Location::fromArray([
            'lat' => fake()->latitude(),
            'lon' => fake()->longitude(),
        ]),
        CarbonImmutable::make(fake()->date())
    );
})->throws(InvalidWeatherResponse::class);

it('test weather bit weather service throw an InvalidWeatherResponse exception when invalid service response and response status code is not 200  ', function () {
    Http::fake([
          config('services.weather.weather_bit.base_url').'*'  => Http::response([ Str::random()],fake()->numberBetween(400,404)),
    ]);
    config([ 'services.weather.service' => 'weather_bit' ]);
    WeatherServiceFactory::make()->getWeather(
        Location::fromArray([
            'lat' => fake()->latitude(),
            'lon' => fake()->longitude(),
        ]),
        CarbonImmutable::make(fake()->date())
    );
})->repeat(5)->throws(InvalidWeatherResponse::class);
