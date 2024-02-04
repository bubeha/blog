<?php

declare(strict_types=1);

namespace App\User\Application\Auth;

use Symfony\Component\HttpFoundation\Request;

interface TokenExtractor
{
    public function getToken(Request $request): ?string;
}
