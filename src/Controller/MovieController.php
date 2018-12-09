<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * {@inheritdoc}
     * @Route("/{page}", name="movie_list", defaults={"page"=1})
     */
    public function listAction(EntityManagerInterface $entityManager, PaginatorInterface $paginator, int $page = 1): Response
    {
        $moviesQuery = $entityManager->getRepository(Movie::class)->getAllQuery();
        $pagination = $paginator->paginate($moviesQuery, $page);

        return $this->render('Movie/list.html.twig', ['pagination' => $pagination]);
    }

    /**
     * {@inheritdoc}
     * @Route("/movie/{id}", name="movie_details")
     */
    public function detailsAction(Request $request, Movie $movie): Response
    {
        return $this->render('Movie/details.html.twig', ['movie' => $movie, 'page' => $request->query->get('page', 1)]);
    }
}
