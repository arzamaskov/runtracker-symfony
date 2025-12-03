<?php

declare(strict_types=1);

namespace App\Tests\Functional\Identity\Infrastructure\Repository;

use App\Identity\Domain\Factory\UserFactory;
use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Identity\Infrastructure\Repository\DoctrineUserRepository;
use App\Tests\Resource\Fixture\UserFixture;
use App\Tests\TestCase;
use App\Tests\Tools\FakerTools;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

class DoctrineRepositoryTest extends TestCase
{
    use FakerTools;

    private UserRepositoryInterface $repository;
    private UserFactory $factory;
    private AbstractDatabaseTool $databaseTool;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->getService(DoctrineUserRepository::class);
        $this->factory = $this->getService(UserFactory::class);
        $this->databaseTool = $this->getService(DatabaseToolCollection::class)->get();
    }

    public function test_user_added_successfully(): void
    {
        // arrange
        $email = $this->getFaker()->email();
        $password = $this->getFaker()->password();

        $user = $this->factory->create($email, $password);

        // act
        $this->repository->add($user);

        // assert
        $existingUser = $this->repository->findById($user->id());
        self::assertEquals($user->id(), $existingUser->id());
    }

    public function test_user_found_by_id_successfully(): void
    {
        // arrange
        $this->databaseTool->loadFixtures([UserFixture::class]);
        $user = $this->repository->findByEmail(UserFixture::EMAIL);

        // act
        $existingUser = $this->repository->findById($user->id());

        // assert
        self::assertEquals($user->id(), $existingUser->id());
    }
}
