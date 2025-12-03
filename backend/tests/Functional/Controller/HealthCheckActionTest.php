<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;

final class HealthCheckActionTest extends TestCase
{
    public function test_request_responded_successfully(): void
    {
        // arrange
        $client = self::createClient();

        // act
        $client->request(Request::METHOD_GET, '/healthcheck');

        // assert
        self::assertResponseIsSuccessful();
        $jsonResponse = json_decode($client->getResponse()->getContent(), true);
        self::assertEquals('OK', $jsonResponse['status']);
    }
}
