<?php

namespace App\Services\Weather;

use App\Services\Weather\Contracts\DataObjects\WeatherPayloadDataObject;
use App\Services\Weather\Contracts\DataObjects\WeatherResponseDataObject;
use App\Services\Weather\Contracts\WeatherService;
use App\Services\Weather\Exceptions\InvalidWeatherResponse;
use App\ValueObjects\Location;
use Carbon\CarbonImmutable;
use Illuminate\Http\Client\PendingRequest;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

abstract class BaseWeatherService implements WeatherService
{
    public function __construct(
        protected PendingRequest $http,
        protected string $baseUrl
    ) {
        $this->http = $this->http->timeout(
            seconds: 15
        )->baseUrl(
            url: $this->baseUrl
        )->acceptJson();
    }

    public function getWeather(Location $location, CarbonImmutable $date): WeatherResponseDataObject
    {
        $response = $this->performRequest(
            location: $location,
            date: $date
        );
        $this->ensureResponseIsValid(
            response: $response
        );

        return $this->buildResponse(
            response: $response
        );
    }

    /**
     * @throws Throwable
     */
    protected function ensureResponseIsValid(array $response): void
    {
        if (! $this->isResponseValid($response)) {
            $this->throwInvalidResponseException($response);
        }
    }

    protected function throwInvalidResponseException($response)
    {
        throw new InvalidWeatherResponse(
            message: sprintf('Invalid Weather response %s', json_encode($response)),
            code: Response::HTTP_BAD_REQUEST
        );
    }

    protected function performRequest(Location $location, CarbonImmutable $date): array
    {
        return $this->http->get(
            url: $this->requestPath(),
            query: $this->buildPayload($location, $date)->toArray()
        )->throw(function ($response) {
            $this->throwInvalidResponseException($response->json());
        })->json();
    }

    abstract protected function requestPath(): string;

    abstract protected function buildPayload(Location $location, CarbonImmutable $date): WeatherPayloadDataObject;

    abstract protected function buildResponse(array $response): WeatherResponseDataObject;

    abstract public function isResponseValid(array $response): bool;
}
