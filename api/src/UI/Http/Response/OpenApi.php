<?php

declare(strict_types=1);

namespace App\UI\Http\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

final class OpenApi extends JsonResponse
{
    public static function fromPayload(mixed $payload, int $status): self
    {
        return new self($payload, $status);
    }

    public static function empty(int $status): self
    {
        return new self(null, $status);
    }
}
