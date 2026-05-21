<?php

namespace App\Repository;

use App\Entity\PersonajeHabilidad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PersonajeHabilidad>
 *
 * @method PersonajeHabilidad|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonajeHabilidad|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonajeHabilidad[]    findAll()
 * @method PersonajeHabilidad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonajeHabilidadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonajeHabilidad::class);
    }

//    /**
//     * @return PersonajeHabilidad[] Returns an array of PersonajeHabilidad objects
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

//    public function findOneBySomeField($value): ?PersonajeHabilidad
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
