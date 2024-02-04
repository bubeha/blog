<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Query;

use App\Shared\Application\Bus\Query\Query;
use App\Shared\Application\Bus\Query\QueryBus;
use App\Shared\Application\Bus\Query\Response;
use App\Shared\Infrastructure\Bus\HandlerBuilder;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class MessengerQueryBus implements QueryBus
{
    private readonly MessageBusInterface $messageBus;

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

    public function handle(Query $query): ?Response
    {
        /** @var HandledStamp $stamp */
        $stamp = $this->messageBus->dispatch($query)->last(HandledStamp::class);

        return $stamp->getResult();
    }
}
