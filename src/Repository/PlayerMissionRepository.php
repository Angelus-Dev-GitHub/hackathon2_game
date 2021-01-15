<?php

namespace App\Repository;

use App\Entity\PlayerMission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlayerMission|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayerMission|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayerMission[]    findAll()
 * @method PlayerMission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerMissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayerMission::class);
    }

    public function resetPlayerMissions()
    {
        return $this->createQueryBuilder('p')
            ->delete()
            ->getQuery()
            ->execute();
    }

    // /**
    //  * @return PlayerMission[] Returns an array of PlayerMission objects
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
    public function findOneBySomeField($value): ?PlayerMission
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
