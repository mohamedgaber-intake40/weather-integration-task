<?php
beforeEach(function () {
    $this->temperatureValue = fake()->randomFloat();
    Http::fake([
        config('services.weather.open_meteo_weather.base_url').'*'  => Http::response([ 'daily' => [ 'apparent_temperature_max' => [ $this->temperatureValue ] ] ]),
        config('services.weather.weather_bit.base_url').'*' => Http::response([ 'data' => [ [ 'temp' => $this->temperatureValue ] ] ]),
    ]);
});
it('ensure lat is required', function () {
    $lon      = fake()->longitude();
    $date     = fake()->date(max: now()->toDateString());
    $response = $this->getJson(route('api.weather', [
        'lon'  => $lon,
        'date' => $date
    ]));
    $response->assertJsonValidationErrorFor('lat');
    $response->assertJsonPath('errors.lat', __('validation.required', [ 'attribute' => 'lat' ]));
});

it('ensure lat is numeric', function () {
    $lat      = Str::random();
    $lon      = fake()->longitude();
    $date     = fake()->date(max: now()->toDateString());
    $response = $this->getJson(route('api.weather', [
        'lat'  => $lat,
        'lon'  => $lon,
        'date' => $date
    ]));
    $response->assertJsonValidationErrorFor('lat');
    $response->assertJsonPath('errors.lat', __('validation.numeric', [ 'attribute' => 'lat' ]));
});

it('ensure lat is valid latitude', function ($lat) {
    $lon      = fake()->longitude();
    $date     = fake()->date(max: now()->toDateString());
    $response = $this->getJson(route('api.weather', [
        'lat'  => $lat,
        'lon'  => $lon,
        'date' => $date
    ]));
    $response->assertJsonValidationErrorFor('lat');
})->with([
    fake()->randomFloat(null,-100,-91),
    fake()->randomFloat(null,91,100),
]);

it('ensure lon is required', function () {
    $lat      = fake()->latitude();
    $date     = fake()->date(max: now()->toDateString());
    $response = $this->getJson(route('api.weather', [
        'lat'  => $lat,
        'date' => $date
    ]));
    $response->assertJsonValidationErrorFor('lon');
    $response->assertJsonPath('errors.lon', __('validation.required', [ 'attribute' => 'lon' ]));
});

it('ensure lon is numeric', function () {
    $lat     = fake()->latitude();
    $lon      = Str::random();
    $date     = fake()->date(max: now()->toDateString());
    $response = $this->getJson(route('api.weather', [
        'lat'  => $lat,
        'lon'  => $lon,
        'date' => $date
    ]));
    $response->assertJsonValidationErrorFor('lon');
    $response->assertJsonPath('errors.lon', __('validation.numeric', [ 'attribute' => 'lon' ]));
});

it('ensure lon is valid longitude', function ($lon) {
    $lat      = fake()->latitude();
    $date     = fake()->date(max: now()->toDateString());
    $response = $this->getJson(route('api.weather', [
        'lat'  => $lat,
        'lon'  => $lon,
        'date' => $date
    ]));
    $response->assertJsonValidationErrorFor('lon');
})->with([
    fake()->randomFloat(null,-190,-181),
    fake()->randomFloat(null,181,190),
]);

it('ensure date is required', function () {
    $lat      = fake()->latitude();
    $lon      = fake()->longitude();
    $response = $this->getJson(route('api.weather', [
        'lat'  => $lat,
        'lon'  => $lon,
    ]));
    $response->assertJsonValidationErrorFor('date');
    $response->assertJsonPath('errors.date', __('validation.required', [ 'attribute' => 'date' ]));
});

it('ensure date is a date', function () {
    $lat      = fake()->latitude();
    $lon      = fake()->longitude();
    $date =  Str::random();
    $response = $this->getJson(route('api.weather', [
        'lat'  => $lat,
        'lon'  => $lon,
        'date' => $date
    ]));
    $response->assertJsonValidationErrorFor('date');
    $response->assertJsonPath('errors.date', __('validation.date', [ 'attribute' => 'date' ]));
});

it('ensure date is a valid date format', function () {
    $lat      = fake()->latitude();
    $lon      = fake()->longitude();
    $date =  fake()->date('d-m-Y');
    $response = $this->getJson(route('api.weather', [
        'lat'  => $lat,
        'lon'  => $lon,
        'date' => $date
    ]));
    $response->assertJsonValidationErrorFor('date');
    $response->assertJsonPath('errors.date', __('validation.date_format', [ 'attribute' => 'date','format' => 'Y-m-d' ]));
});

it('returns a successful weather response with integrated weather services', function ($weatherService) {
    config(['services.weather.service' => $weatherService]);
    $lat      = fake()->latitude();
    $lon      = fake()->longitude();
    $date     = fake()->date(max: now()->toDateString());
    $response = $this->getJson(route('api.weather', [
        'lat'  => $lat,
        'lon'  => $lon,
        'date' => $date
    ]));
    $response->assertOk();
    expect($response->json('data.temperature'))->toEqual($this->temperatureValue);

})->with(['weather_bit','open_meteo_weather'])->repeat(100);


it('ensure a successful weather response when change weather service without affecting the code', function ($weatherServiceOne,$weatherServiceTwo) {
    config(['services.weather.service' => $weatherServiceOne]);
    $lat      = fake()->latitude();
    $lon      = fake()->longitude();
    $date     = fake()->date(max: now()->toDateString());
    $response = $this->getJson(route('api.weather', [
        'lat'  => $lat,
        'lon'  => $lon,
        'date' => $date
    ]));
    $response->assertOk();
    expect($response->json('data.temperature'))->toEqual($this->temperatureValue);
    config(['services.weather.service' =>$weatherServiceTwo]);
    $lat      = fake()->latitude();
    $lon      = fake()->longitude();
    $date     = fake()->date(max: now()->toDateString());
    $response = $this->getJson(route('api.weather', [
        'lat'  => $lat,
        'lon'  => $lon,
        'date' => $date
    ]));
    $response->assertOk();
    expect($response->json('data.temperature'))->toEqual($this->temperatureValue);


})->with([
    ['open_meteo_weather','weather_bit'],
    ['weather_bit','open_meteo_weather']
])->repeat(100);
