<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class TestCase extends WebTestCase
{
    /**
     * @template T of object
     *
     * @param class-string<T> $serviceName
     */
    protected function getService(string $serviceName): object
    {
        /* @var T */
        return static::getContainer()->get($serviceName);
    }
}
