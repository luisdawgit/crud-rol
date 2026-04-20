<?php

namespace App\Repository;

use App\Entity\ExperienciaHistorial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExperienciaHistorial>
 *
 * @method ExperienciaHistorial|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExperienciaHistorial|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExperienciaHistorial[]    findAll()
 * @method ExperienciaHistorial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExperienciaHistorialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExperienciaHistorial::class);
    }

//    /**
//     * @return ExperienciaHistorial[] Returns an array of ExperienciaHistorial objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ExperienciaHistorial
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
