<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Command;

use App\Shared\Application\Bus\Command\Command;
use App\Shared\Application\Bus\Command\CommandBus;
use App\Shared\Infrastructure\Bus\HandlerBuilder;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

final readonly class MessengerCommandBus implements CommandBus
{
    private MessageBusInterface $messageBus;

    /**
     * @param iterable<callable&object> $commandHandlers
     * @throws \ReflectionException
     */
    public function __construct(iterable $commandHandlers)
    {
        $this->messageBus = new MessageBus([
            new HandleMessageMiddleware(
                new HandlersLocator(HandlerBuilder::fromCallables($commandHandlers)),
            ),
        ]);
    }

    public function handle(Command $command): void
    {
        $this->messageBus->dispatch($command);
    }
}
