<?php

declare(strict_types=1);

namespace App\Controller;

use App\Command\TestCommand;
use App\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final readonly class TestController
{
    public function __construct(private CommandBus $bus)
    {
    }

    #[Route(path: 'test', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        $this->bus->dispatch(new TestCommand());

        return new JsonResponse();
    }
}