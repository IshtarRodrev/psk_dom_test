<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\OfferItems;
use App\Entity\Offers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\OptimisticLockException;

/**
 * @extends ServiceEntityRepository<OfferItems>
 *
 * @method OfferItems|null find($id, $lockMode = null, $lockVersion = null)
 * @method OfferItems|null findOneBy(array $criteria, array $orderBy = null)
 * @method OfferItems[]    findAll()
 * @method OfferItems[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferItemsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OfferItems::class);
    }

    /**
     * @param OfferItems $entity
     * @param bool $flush
     */
    public function save(OfferItems $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param OfferItems $entity
     * @param bool $flush
     */
    public function delete(OfferItems $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}