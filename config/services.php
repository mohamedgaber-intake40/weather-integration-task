<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'weather' => [
        'service' => 'open_meteo_weather',

        'weather_bit' => [
            'base_url' => env('WEATHER_BIT_BASE_URL'),
            'api_key' =>  env('WEATHER_BIT_API_KEY'),
            'service_class' => \App\Services\Weather\Integrations\WeatherBit\WeatherBitService::class
        ],

        'open_meteo_weather' => [
            'base_url' => env('OPEN_METEO_WEATHER_BASE_URL'),
            'timezone' => 'Africa/Cairo',
            'service_class' => \App\Services\Weather\Integrations\OpenMeteoWeather\OpenMeteoWeatherService::class
        ],
    ],


];
