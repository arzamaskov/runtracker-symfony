<?php

declare(strict_types=1);

namespace App\Tests\Functional\Identity\Presentation\Api\Controller;

use App\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterActionTest extends TestCase
{
    public function test_successful_registration(): void
    {
        // arrange
        $client = static::createClient();
        $router = self::getContainer()->get('router');

        // act
        $client->request(
            method: Request::METHOD_POST,
            uri: $router->generate('register'),
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode([
                'email' => 'test@example.com',
                'name' => 'John Doe',
                'password' => 'password123',
            ])
        );

        // assert
        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
        self::assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);

        self::assertTrue($data['success']);
        self::assertArrayHasKey('id', $data['data']);
        self::assertNotEmpty($data['data']['id']);
    }

    public function test_registration_with_invalid_email(): void
    {
        // arrange
        $client = static::createClient();
        $router = self::getContainer()->get('router');

        // act
        $client->request(
            method: Request::METHOD_POST,
            uri: $router->generate('register'),
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode([
                'email' => 'invalid-email',
                'name' => 'John Doe',
                'password' => 'password123',
            ])
        );

        // assert
        self::assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_registration_with_short_password(): void
    {
        // arrange
        $client = static::createClient();
        $router = self::getContainer()->get('router');

        // act
        $client->request(
            method: Request::METHOD_POST,
            uri: $router->generate('register'),
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode([
                'email' => 'test@example.com',
                'name' => 'John Doe',
                'password' => '123',
            ])
        );

        // assert
        self::assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_registration_with_duplicate_email(): void
    {
        $client = static::createClient();
        $router = self::getContainer()->get('router');

        // Первая регистрация
        $client->request(
            method: 'POST',
            uri: $router->generate('register'),
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode([
                'email' => 'duplicate@example.com',
                'name' => 'John Doe',
                'password' => 'SecurePass123',
            ])
        );

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);

        // Повторная регистрация с тем же email
        $client->request(
            method: 'POST',
            uri: $router->generate('register'),
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode([
                'email' => 'duplicate@example.com',
                'name' => 'Jane Doe',
                'password' => 'AnotherPass456',
            ])
        );
        self::assertResponseStatusCodeSame(Response::HTTP_CONFLICT);

        $data = json_decode($client->getResponse()->getContent(), true);

        self::assertFalse($data['success']);
        self::assertEquals('EMAIL_ALREADY_EXISTS', $data['error']['code']);
    }
}
