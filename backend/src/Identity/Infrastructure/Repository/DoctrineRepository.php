<?php

declare(strict_types=1);

namespace App\Identity\Infrastructure\Repository;

use App\Identity\Domain\Entity\User;
use App\Identity\Domain\Repository\UserRepository;
use App\Identity\Domain\ValueObject\UserId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineRepository extends ServiceEntityRepository implements UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findById(UserId $id): ?User
    {
        return $this->find($id->toString());
    }

    public function findByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }
}
