<?php

declare(strict_types=1);

namespace App\Services\Weather\Exceptions;

use Exception;

class InvalidWeatherResponse extends Exception
{
    public function render()
    {
        return apiResponse()
            ->error()
            ->message($this->message)
            ->statusCode($this->code)
            ->send();
    }

    public function report()
    {
        return false;
    }
}
