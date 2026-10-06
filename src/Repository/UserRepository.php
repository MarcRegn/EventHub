<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class );
    }

    public function save(?User $user = null){
        $this->getEntityManager()->Flush($user);
    }

    public function persist(?User $user = null){
        $this->getEntityManager()->persist($user);
    }

    public function persistAndSave(?User $user = null){
    $this->persist($user);
    $this->save($user);
    }
}
