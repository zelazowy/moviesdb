<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\Movie;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class MovieRepository extends EntityRepository
{
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
