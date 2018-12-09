<?php declare(strict_types=1);

namespace App\Repository;

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
}
