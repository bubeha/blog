<?php

declare(strict_types=1);

namespace App\User\Domain\ValueObject;

use Webmozart\Assert\Assert;

final readonly class HashedPassword implements \Stringable
{
    private const COST = 12;
    private const MIN_LENGTH = 6;

    private function __construct(private string $hashedPassword) {}

    public static function encode(string $plainPassword): self
    {
        Assert::minLength($plainPassword, self::MIN_LENGTH, 'Min ' . self::MIN_LENGTH . ' characters password');

        /** @var string|false|null $hashedPassword */
        $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT, ['cost' => self::COST]);

        if (!$hashedPassword) {
            throw new \RuntimeException('Server error hashing password');
        }

        return new self($hashedPassword);
    }

    public static function fromHash(string $hashedPassword): self
    {
        return new self($hashedPassword);
    }

    public function match(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->hashedPassword);
    }

    public function __toString(): string
    {
        return $this->hashedPassword;
    }
}
