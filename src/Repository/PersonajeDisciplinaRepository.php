<?php

namespace App\Repository;

use App\Entity\PersonajeDisciplina;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PersonajeDisciplina>
 *
 * @method PersonajeDisciplina|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonajeDisciplina|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonajeDisciplina[]    findAll()
 * @method PersonajeDisciplina[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonajeDisciplinaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonajeDisciplina::class);
    }

//    /**
//     * @return PersonajeDisciplina[] Returns an array of PersonajeDisciplina objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PersonajeDisciplina
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
