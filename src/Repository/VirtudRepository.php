<?php

namespace App\Repository;

use App\Entity\Virtud;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Virtud>
 *
 * @method Virtud|null find($id, $lockMode = null, $lockVersion = null)
 * @method Virtud|null findOneBy(array $criteria, array $orderBy = null)
 * @method Virtud[]    findAll()
 * @method Virtud[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VirtudRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Virtud::class);
    }

//    /**
//     * @return Virtud[] Returns an array of Virtud objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Virtud
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
