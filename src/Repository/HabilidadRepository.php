<?php

namespace App\Repository;

use App\Entity\Habilidad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Habilidad>
 *
 * @method Habilidad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Habilidad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Habilidad[]    findAll()
 * @method Habilidad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HabilidadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Habilidad::class);
    }

    // Uncomment and add methods as needed
}
