<?php

declare(strict_types=1);

namespace App\Tests\Shared\Infrastructure\Bus;

use App\Shared\Application\Bus\Command\Command;
use App\Shared\Application\Bus\Command\CommandHandler;

trait HandlersProvider
{
    public static function callableHandlersProvider(): array
    {
        $correctHandler = self::getCorrectHandler();
        $secondCorrectHandler = self::getSecondCorrectHandler();
        $incorrectHandler = self::getIncorrectHandler();

        return [
            'should be correct' => [
                'actual' => [
                    $correctHandler,
                    $secondCorrectHandler,
                    self::getHandlerWithoutType(),
                ],
                'expect' => [
                    Command::class => [$correctHandler],
                    FakeCommand::class => [$secondCorrectHandler],
                ],
            ],
            'should be empty' => [
                'actual' => [
                    $incorrectHandler
                ],
                'expect' => [],
            ],
            'should ignore incorrect handler' => [
                'actual' => [
                    $correctHandler,
                    $incorrectHandler,
                ],
                'expect' => [
                    Command::class => [$correctHandler],
                ],
            ],
            'should be ignore duplicates' => [
                'actual' => [
                    $correctHandler,
                    $correctHandler,
                ],
                'expect' => [
                    Command::class => [$correctHandler],
                ],
            ],
        ];
    }

    protected static function getCorrectHandler(): CommandHandler
    {
        return new class implements CommandHandler {
            public function __invoke(Command $command)
            {
            }
        };
    }

    protected static function getSecondCorrectHandler(): CommandHandler
    {
        return new class implements CommandHandler {
            public function __invoke(FakeCommand $command)
            {
            }
        };
    }

    protected static function getIncorrectHandler(): CommandHandler
    {
        return new class implements CommandHandler {
            public function __invoke()
            {
            }
        };
    }

    protected static function getHandlerWithoutType(): CommandHandler
    {
        return new class implements CommandHandler {
            public function __invoke($withoutType)
            {
            }
        };
    }
}
