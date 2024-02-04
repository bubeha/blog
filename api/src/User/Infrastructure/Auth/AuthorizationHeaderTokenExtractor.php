<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Auth;

use App\User\Application\Auth\TokenExtractor as TokenExtractorInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class AuthorizationHeaderTokenExtractor implements TokenExtractorInterface
{
    public function __construct(private string $prefix, private string $headerKey) {}

    public function getToken(Request $request): ?string
    {
        if (!$this->support($request)) {
            return null;
        }

        /** @var string $token */
        $token = $request->headers->get($this->headerKey);

        return substr($token, \strlen($this->prefix) + 1);
    }

    private function support(Request $request): bool
    {
        return $request->headers->has($this->headerKey) && str_starts_with((string) $request->headers->get($this->headerKey), $this->prefix);
    }
}
