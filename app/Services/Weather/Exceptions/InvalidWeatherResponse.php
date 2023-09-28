<?php

namespace App\Services\Weather\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class InvalidWeatherResponse extends \Exception
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
