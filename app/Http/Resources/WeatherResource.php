<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Services\Weather\Contracts\DataObjects\WeatherResponseDataObject;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    /**
     * @var WeatherResponseDataObject
     * */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'temperature' => $this->resource->getTemperature(),
        ];
    }
}
