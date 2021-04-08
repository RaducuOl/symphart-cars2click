<?php

namespace App\Repository;

use App\Entity\PageUtility;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PageUtility|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageUtility|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageUtility[]    findAll()
 * @method PageUtility[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageUtilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageUtility::class);
    }

    // /**
    //  * @return PageUtility[] Returns an array of PageUtility objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PageUtility
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
