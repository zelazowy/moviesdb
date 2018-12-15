<?php declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\Query;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\Comment;
use App\Entity\Movie;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function getAllQuery(string $sort = 'id', string $order = 'ASC'): Query
    {
        return $this
            ->createQueryBuilder('movie')
            ->orderBy("movie.{$sort}", $order)
            ->getQuery();
    }

    public function getWithAcceptedComments(int $id): ?Movie
    {
        return $this
            ->createQueryBuilder('movie')
            ->where('movie.id = :id')
            ->setParameter('id', $id)
            ->leftJoin('movie.comments', 'comments', Query\Expr\Join::WITH, 'comments.status = :status')
            ->addSelect('comments')
            ->setParameter('status', Comment::STATUS_ACCEPTED)
            ->getQuery()
            ->getSingleResult();
    }
}
