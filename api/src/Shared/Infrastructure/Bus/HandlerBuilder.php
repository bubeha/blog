<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus;

final class HandlerBuilder
{
    /**
     * @param iterable<callable&object> $callables
     * @return array<class-string, list{callable&object}>
     * @throws \ReflectionException
     */
    public static function fromCallables(iterable $callables): array
    {
        $callablesHandlers = [];

        foreach ($callables as $callable) {
            /** @var null|class-string $result */
            $result = self::extracted($callable);

            if ($result) {
                $callablesHandlers[$result] = [$callable];
            }
        }

        return $callablesHandlers;
    }

    /**
     * @param callable&object $callable
     * @throws \ReflectionException
     */
    private static function extracted(object $callable): ?string
    {
        $reflectionClass = new \ReflectionClass($callable);

        $result = $reflectionClass->getMethod('__invoke');

        if (empty($result->getParameters())) {
            return null;
        }

        $type = $result->getParameters()[0]->getType();

        return $type instanceof \Stringable ? (string) $type : null;
    }
}
