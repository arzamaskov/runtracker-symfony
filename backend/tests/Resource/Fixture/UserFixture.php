<?php

declare(strict_types=1);

namespace App\Tests\Resource\Fixture;

use App\Identity\Domain\Factory\UserFactory;
use App\Tests\Tools\FakerTools;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class UserFixture extends Fixture
{
    use FakerTools;

    public const string EMAIL = 'test.user@example.com';

    public function __construct(private readonly UserFactory $factory)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $password = $this->getFaker()->password();
        $user = $this->factory->create(self::EMAIL, $password);
        $manager->persist($user);
        $manager->flush();
    }
}
