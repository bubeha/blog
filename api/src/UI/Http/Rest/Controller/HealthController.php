<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller;

use App\UI\Http\Response\OpenApi;

final class HealthController
{
    public function __invoke(): OpenApi
    {
        return OpenApi::fromPayload(['status' => 'alive'], 200);
    }
}
