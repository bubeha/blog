<?php

declare(strict_types=1);

namespace App\Tests\Shared\UI\Http\Rest\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class HealthControllerTest extends WebTestCase
{
    public function testHealthAction(): void
    {
        $client = self::createClient();

        $client->request('GET', '/health');

        self::assertResponseIsSuccessful();
        self::assertSame('{"status":"alive"}', $client->getResponse()->getContent());
    }
}
