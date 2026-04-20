<?php

namespace App\Repository;

use App\Entity\Disciplina;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Disciplina>
 *
 * @method Disciplina|null find($id, $lockMode = null, $lockVersion = null)
 * @method Disciplina|null findOneBy(array $criteria, array $orderBy = null)
 * @method Disciplina[]    findAll()
 * @method Disciplina[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DisciplinaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Disciplina::class);
    }

//    /**
//     * @return Disciplina[] Returns an array of Disciplina objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Disciplina
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
