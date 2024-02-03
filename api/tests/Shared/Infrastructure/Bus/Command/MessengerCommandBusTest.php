<?php

declare(strict_types=1);

namespace App\Tests\Shared\Infrastructure\Bus\Command;

use App\Shared\Application\Bus\Command\Command;
use App\Shared\Application\Bus\Command\CommandHandler;
use App\Shared\Infrastructure\Bus\Command\MessengerCommandBus;
use App\Tests\Shared\Infrastructure\Bus\FakeCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;

final class MessengerCommandBusTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function testCommandBusShouldThrowNotFoundException(): void
    {
        $this->expectException(NoHandlerForMessageException::class);

        $bus = new MessengerCommandBus([]);
        $bus->handle(new class implements Command{});
    }

    /**
     * @throws \ReflectionException
     */
    public function testCommandBusShouldBeExecuted(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('The command has been executed');

        $bus = new MessengerCommandBus([new class implements CommandHandler {
            public function __invoke(FakeCommand $command)
            {
                throw new \RuntimeException('The command has been executed');
            }
        }]);

        $bus->handle(new FakeCommand());
    }
}
