<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Symfony;

use App\User\Domain\ValueObject\HashedPassword;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

final class PasswordHasher implements PasswordHasherInterface
{
    public function hash(#[\SensitiveParameter] string $plainPassword): string
    {
        return (string) HashedPassword::encode($plainPassword);
    }

    public function verify(string $hashedPassword, #[\SensitiveParameter] string $plainPassword): bool
    {
        return HashedPassword::fromHash($hashedPassword)->match($plainPassword);
    }

    public function needsRehash(string $hashedPassword): bool
    {
        return false;
    }
}
