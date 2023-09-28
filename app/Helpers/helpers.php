<?php

declare(strict_types=1);

use App\Utilities\ApiResponse\Factory\ApiResponseFactory;

function apiResponse()
{
    return app(ApiResponseFactory::class);
}
