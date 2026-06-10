<?php

namespace App\Repository;

use App\Entity\Trasfondo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trasfondo>
 *
 * @method Trasfondo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trasfondo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trasfondo[]    findAll()
 * @method Trasfondo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrasfondoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trasfondo::class);
    }

//    /**
//     * @return Trasfondo[] Returns an array of Trasfondo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Trasfondo
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
