<?php

namespace App\Repository;

use App\Entity\Vehicule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicule>
 *
 * @method Vehicule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicule[]    findAll()
 * @method Vehicule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehiculeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicule::class);
    }

    public function add(Vehicule $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Vehicule $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Vehicule[] Returns an array of Vehicule objects
     */
    public function findAllWithFilters($filters): array
    {
        $qb = $this->createQueryBuilder('v');
        if (array_key_exists('kMin', $filters)
          && $filters['kMin'] !== ''){
          $qb->andWhere('v.kilometrage >= :valMin')
            ->setParameter('valMin', $filters['kMin']);
        }

      if (array_key_exists('kMax', $filters)
        && $filters['kMax'] !== ''){
        $qb->andWhere('v.kilometrage <= :valMax')
          ->setParameter('valMax', $filters['kMax']);
      }

      if (array_key_exists('order-price', $filters)
        && $filters['order-price'] !== ''){
        $qb->orderBy('v.price', $filters['order-price']);
      }

      return $qb->getQuery()->getResult();
    }



    /*
     *           $qb->andWhere('v.kilometrage >= :kmin')
            ->setParameter('kmin', $filters['kMin']);
          if (array_key_exists('kMax', $filters) && $filters['kMax'] !== ''){
        $qb->andWhere('v.kilometrage <= :kmax')
          ->setParameter('kmax', $filters['kMax']);
      }
    */

//    public function findOneBySomeField($value): ?Vehicule
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
