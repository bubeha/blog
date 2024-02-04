<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Auth;

use App\User\Application\Auth\TokenManager;
use DateTimeImmutable;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class JwtTokenManager implements TokenManager
{
    private const ALGORITHM = 'HS256';

    public function __construct(private string $key = 'hiG8DlOKvtih6AxlZn5XKImZ06yu8I3mkOzaJrEuW8yAv8Jnkw330uMt8AEqQ5LB')
    {
    }

    public function create(UserInterface $user): string
    {
        $token = [
            'iat' => (new DateTimeImmutable('now'))->getTimestamp(),
            'exp' => (new DateTimeImmutable())->add(new \DateInterval('PT1H'))->getTimestamp(),
            'data' => [
                'user_id' => $user->getUserIdentifier(),
            ],
        ];

        return JWT::encode($token, $this->key, self::ALGORITHM);
    }

    public function decode(string $token): \stdClass
    {
        return JWT::decode($token, new Key($this->key, self::ALGORITHM));
    }
}
