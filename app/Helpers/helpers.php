<?php


use App\Utilities\ApiResponse\Factory\ApiResponseFactory;

function apiResponse()
{
    return app(ApiResponseFactory::class);
}
