<?php

namespace App\Repository;

use App\Entity\ClanDisciplina;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClanDisciplina>
 *
 * @method ClanDisciplina|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClanDisciplina|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClanDisciplina[]    findAll()
 * @method ClanDisciplina[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClanDisciplinaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClanDisciplina::class);
    }

//    /**
//     * @return ClanDisciplina[] Returns an array of ClanDisciplina objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ClanDisciplina
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
