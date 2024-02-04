<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Symfony;

use Symfony\Component\PasswordHasher\Hasher\PasswordHasherAwareInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class User implements UserInterface, PasswordHasherAwareInterface
{
    public function __construct(private string $email)
    {
    }

    public function getRoles(): array
    {
        return [
            'ROLE_USER',
        ];
    }

    public function eraseCredentials(): void
    {
        // ignore
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getPasswordHasherName(): ?string
    {
        return 'hasher';
    }
}
