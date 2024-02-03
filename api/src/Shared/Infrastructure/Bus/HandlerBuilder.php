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
            $result = self::extract($callable);

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
    private static function extract(object $callable): ?string
    {
        $reflectionClass = new \ReflectionClass($callable);

        $method = $reflectionClass->getMethod('__invoke');

        if (empty($method->getParameters())) {
            return null;
        }

        /** @var \ReflectionNamedType|null $fistParameterType */
        $fistParameterType = $method->getParameters()[0]->getType();

        return $fistParameterType?->getName();
    }
}
