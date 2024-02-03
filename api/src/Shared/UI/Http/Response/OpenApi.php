<?php

declare(strict_types=1);

namespace App\Shared\UI\Http\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

final class OpenApi extends JsonResponse
{
    public static function fromPayload(array|string $payload, int $status): self
    {
        return new self($payload, $status);
    }

    public static function empty(int $status): self
    {
        return new self(null, $status);
    }
}