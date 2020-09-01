<?php

namespace App\Repository;

use App\Entity\ProUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProUser[]    findAll()
 * @method ProUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProUser::class);
    }

    public function search($jobCategory)
    {
        return $this->createQueryBuilder('ProUser')
            ->andWhere('ProUser.jobCategory LIKE :jobCategory')
            ->setParameter('jobCategory','%'.$jobCategory.'%')
            ->getQuery()
            ->execute()
        ;
    }


    /*
    public function findOneBySomeField($value): ?ProUser
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
