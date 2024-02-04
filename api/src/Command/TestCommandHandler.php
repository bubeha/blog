<?php

declare(strict_types=1);

namespace App\Command;

use App\Shared\Domain\Bus\Command\CommandHandler;

final readonly class TestCommandHandler implements CommandHandler
{
    public function __invoke(TestCommand $command): void
    {
        dd($command->getA());
    }
}
