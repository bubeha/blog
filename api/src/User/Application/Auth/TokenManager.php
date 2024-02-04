<?php

declare(strict_types=1);

namespace App\User\Application\Auth;

use Symfony\Component\Security\Core\User\UserInterface;

interface TokenManager
{
    public function create(UserInterface $user): string;

    public function decode(string $token): mixed;
}
