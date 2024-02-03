<?php

declare(strict_types=1);

namespace App\Tests\Shared\UI\Http\Response;

use App\Shared\UI\Http\Response\OpenApi;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

final class OpenApiTest extends TestCase
{
    public function testResponseIsEmpty(): void
    {
        $response = OpenApi::empty(200);

        self::assertSame('{}', $response->getContent());
    }

    public static function payloadProvider(): array
    {
        return [
            ['actual' => null, 'expected' => '{}'],
            ['actual' => '', 'expected' => '""'],
            ['actual' => [1, '2', 3], 'expected' => '[1,"2",3]'],
            ['actual' => ['foo' => 'bar', 'number' => 4], 'expected' => '{"foo":"bar","number":4}'],
        ];
    }

    #[DataProvider('payloadProvider')]
    public function testResponseFromPayload(mixed $actual, string $expected): void
    {
        $response = OpenApi::fromPayload($actual, 200);

        self::assertSame($expected, $response->getContent());
    }

    public static function statusProvider(): array
    {
        return [
            ['status' => Response::HTTP_CONTINUE],
            ['status' => Response::HTTP_OK],
            ['status' => Response::HTTP_FOUND],
            ['status' => Response::HTTP_NOT_FOUND],
            ['status' => Response::HTTP_INTERNAL_SERVER_ERROR],
        ];
    }

    #[DataProvider('statusProvider')]
    public function testResponseStatus(int $status): void
    {
        $response = OpenApi::empty($status);

        self::assertSame($status, $response->getStatusCode());
    }
}
