<?php

namespace App\Repository;

use App\Entity\Offers;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * @extends ServiceEntityRepository<Offers>
 *
 * @method Offers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offers[]    findAll()
 * @method Offers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offers::class);
    }

    /**
     * @param Offers $entity
     * @param bool $flush
     */
    public function save(Offers $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}