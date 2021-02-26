<?php

namespace App\Repository;

use App\Entity\NotificationConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NotificationConfig|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotificationConfig|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotificationConfig[]    findAll()
 * @method NotificationConfig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationConfigRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NotificationConfig::class);
    }

    // /**
    //  * @return NotificationConfig[] Returns an array of NotificationConfig objects
    //  */
    /*
      public function findByExampleField($value)
      {
      return $this->createQueryBuilder('n')
      ->andWhere('n.exampleField = :val')
      ->setParameter('val', $value)
      ->orderBy('n.id', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
      ;
      }
     */

    /*
      public function findOneBySomeField($value): ?NotificationConfig
      {
      return $this->createQueryBuilder('n')
      ->andWhere('n.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
      ;
      }
     */
}
