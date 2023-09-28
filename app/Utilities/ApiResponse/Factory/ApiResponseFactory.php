<?php


namespace App\Utilities\ApiResponse\Factory;



use App\Utilities\ApiResponse\Builder\ErrorApiResponseBuilder;
use App\Utilities\ApiResponse\Builder\SuccessApiResponseBuilder;

class ApiResponseFactory
{
    public static function make()
    {
        return app(static::class);
    }

    public function success()
    {
        return app(SuccessApiResponseBuilder::class);
    }

    public function error()
    {
        return app(ErrorApiResponseBuilder::class);
    }
}
