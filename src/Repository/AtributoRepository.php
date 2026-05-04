<?php

namespace App\Repository;

use App\Entity\Atributo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Atributo>
 *
 * @method Atributo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Atributo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Atributo[]    findAll()
 * @method Atributo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AtributoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Atributo::class);
    }

//    /**
//     * @return Atributo[] Returns an array of Atributo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Atributo
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}