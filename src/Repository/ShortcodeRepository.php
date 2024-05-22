<?php

namespace App\Repository;

use App\Entity\Client;
use App\Entity\Shortcode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Shortcode>
 */
class ShortcodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shortcode::class);
    }

    public function findAllByClient(Client $client): array
    {
        $query = $this->createQueryBuilder('url')
            ->leftJoin('url.domain', 'domains')
            ->leftJoin('domains.client', 'client')
            ->addSelect('domains')
            ->andWhere('client.id = :clientId')
            ->setParameter('clientId', $client->getId()->toBinary())
            ->getQuery();

        return $query->getResult();
    }

    //    /**
    //     * @return Url[] Returns an array of Url objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Url
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
