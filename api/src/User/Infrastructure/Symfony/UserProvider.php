<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Symfony;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProvider implements UserProviderInterface
{
    public function refreshUser(UserInterface $user): UserInterface
    {
        dd($user);
    }

    public function supportsClass(string $class): bool
    {
        dd($class);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        dd($identifier);
    }
}
