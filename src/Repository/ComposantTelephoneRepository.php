<?php

namespace App\Repository;

use App\Entity\ComposantTelephone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ComposantTelephone>
 *
 * @method ComposantTelephone|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComposantTelephone|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComposantTelephone[]    findAll()
 * @method ComposantTelephone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComposantTelephoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComposantTelephone::class);
    }

    public function save(ComposantTelephone $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ComposantTelephone $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


//    public function findOneBySomeField($value): ?ComposantTelephone
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
