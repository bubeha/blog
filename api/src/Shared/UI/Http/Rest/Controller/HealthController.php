<?php

declare(strict_types=1);

namespace App\Shared\UI\Http\Rest\Controller;

use App\Shared\UI\Http\Response\OpenApi;

// todo move to apps directory
final class HealthController
{
    public function __invoke(): OpenApi
    {
        return OpenApi::fromPayload(['status' => 'alive'], 200);
    }
}
