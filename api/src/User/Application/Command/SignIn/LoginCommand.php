<?php

declare(strict_types=1);

namespace App\User\Application\Command\SignIn;

use App\Shared\Application\Bus\Command\Command;

final readonly class LoginCommand implements Command
{
    public function __construct(public string $email, public string $password) {}
}
