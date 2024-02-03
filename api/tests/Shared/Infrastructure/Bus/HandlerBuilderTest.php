<?php

declare(strict_types=1);

namespace App\Tests\Shared\Infrastructure\Bus;

use App\Shared\Infrastructure\Bus\HandlerBuilder;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionException;

final class HandlerBuilderTest extends TestCase
{
    use HandlersProvider;

    /**
     * @throws ReflectionException
     */
    public function testExtractShouldThrowNotFoundMethod(): void
    {
        $this->expectException(ReflectionException::class);

        $emptyHandler = new class {
        };

        HandlerBuilder::fromCallables([$emptyHandler]);
    }

    /**
     * @param iterable<callable&object> $actual
     * @throws ReflectionException
     */
    #[DataProvider('callableHandlersProvider')]
    public function testExtractShouldReturnCorrectListOfHandlers(iterable $actual, array $expect): void
    {
        self::assertSame($expect, HandlerBuilder::fromCallables($actual));
    }
}
