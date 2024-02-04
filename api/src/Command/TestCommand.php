<?php

declare(strict_types=1);

namespace App\Command;

use App\Shared\Domain\Bus\Command\Command;

final readonly class TestCommand implements Command
{
    private int $a;

    public function __construct()
    {
        $this->a = 10;
    }

    public function getA(): int
    {
        return $this->a;
    }
}
