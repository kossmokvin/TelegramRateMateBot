<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 *
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }


    /**
     * Returns the quantity of reviews related to the exact chat.
     *
     * @param int $chatId
     * @return int
     */
    public function countByChat(int $chatId): int
    {
        return $this->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->where('r.chat = :chatId')
            ->setParameter('chatId', $chatId)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Returns the average rating of reviews related to the exact chat.
     *
     * @param int $chatId
     * @return float
     */
    public function getChatAverageRating(int $chatId): float
    {
        $avgRating = $this->createQueryBuilder('r')
            ->select('AVG(r.rating) as avg_rating')
            ->where('r.chat = :chatId')
            ->setParameter('chatId', $chatId)
            ->getQuery()
            ->getSingleScalarResult();

        return (float) $avgRating;
    }


//    /**
//     * @return Review[] Returns an array of Review objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Review
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
