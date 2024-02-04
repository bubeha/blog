<?php

declare(strict_types=1);

namespace App\User\Application\Command\SignIn;

use App\Shared\Application\Bus\Command\CommandHandler;
use App\User\Application\Auth\TokenManager;
use App\User\Infrastructure\Symfony\User;

final readonly class LoginCommandHandler implements CommandHandler
{
    public function __construct(private TokenManager $tokenManager)
    {
    }

    public function __invoke(LoginCommand $command): void
    {
        dd($this->tokenManager->create(new User($command->email)));
    }
}
