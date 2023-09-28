<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

class WeatherRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'lat' => ['required', 'numeric', 'min:-90', 'max:90'],
            'lon' => ['required', 'numeric', 'min:-180', 'max:180'],
            'date' => ['required', 'date', 'date_format:Y-m-d'],
        ];
    }
}
