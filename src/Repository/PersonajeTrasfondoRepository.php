<?php

namespace App\Repository;

use App\Entity\PersonajeTrasfondo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PersonajeTrasfondo>
 *
 * @method PersonajeTrasfondo|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonajeTrasfondo|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonajeTrasfondo[]    findAll()
 * @method PersonajeTrasfondo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonajeTrasfondoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonajeTrasfondo::class);
    }

//    /**
//     * @return PersonajeTrasfondo[] Returns an array of PersonajeTrasfondo objects
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

//    public function findOneBySomeField($value): ?PersonajeTrasfondo
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
