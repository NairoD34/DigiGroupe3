<?php

namespace App\Repository;

use App\Entity\StateOfProject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StateOfProject>
 */
class StateOfProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StateOfProject::class);
    }


        public function findByid($value): array
        {
            return $this->createQueryBuilder('p')
                ->andWhere('p.id = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getResult()
           ;
        }
        public function findOneById($value): ?StateOfProject
        {
            return $this->createQueryBuilder('c')
                ->andWhere('c.id = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }
}
