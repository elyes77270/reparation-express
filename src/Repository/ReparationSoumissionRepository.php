<?php

namespace App\Repository;

use App\Entity\ReparationSoumission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReparationSoumission>
 *
 * @method ReparationSoumission|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReparationSoumission|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReparationSoumission[]    findAll()
 * @method ReparationSoumission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReparationSoumissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReparationSoumission::class);
    }

    public function save(ReparationSoumission $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReparationSoumission $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findMostFrequentTelephones(int $limit = 8): array
    {
        return $this->createQueryBuilder('r')
            ->select('r.telephone, COUNT(r.telephone) as frequency')
            ->groupBy('r.telephone')
            ->orderBy('frequency', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
