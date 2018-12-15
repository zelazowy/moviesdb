<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Movie;
use App\Event\CommendAddedEvent;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * {@inheritdoc}
     * @Route("/{page}", name="movie_list", defaults={"page"=1})
     */
    public function list(EntityManagerInterface $entityManager, PaginatorInterface $paginator, int $page = 1): Response
    {
        $moviesQuery = $entityManager->getRepository(Movie::class)->getAllQuery();
        $pagination = $paginator->paginate($moviesQuery, $page);

        return $this->render('Movie/list.html.twig', ['pagination' => $pagination]);
    }

    /**
     * {@inheritdoc}
     * @Route("/movie/{id}", name="movie_details")
     */
    public function details(
        Request $request,
        EntityManagerInterface $entityManager,
        int $id
    ): Response
    {
        $movie = $entityManager->getRepository(Movie::class)->getWithAcceptedComments($id);

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        return $this->render(
            'Movie/details.html.twig',
            [
                'movie' => $movie,
                'page' => $request->query->get('page', 1),
                'commentForm' => $form->createView(),
            ]
        );
    }

    /**
     * {@inheritdoc}
     * @Route("/movie/{id}/addComment", name="movie_add_comment", methods={"POST"})
     */
    public function addComment(
        Request $request,
        EntityManagerInterface $entityManager,
        EventDispatcherInterface $eventDispatcher,
        Session $session,
        Movie $movie
    ): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $comment
                ->setMovie($movie)
                ->setStatus(Comment::STATUS_NEW);

            $entityManager->persist($comment);
            $entityManager->flush();

            $eventDispatcher->dispatch(CommendAddedEvent::class, new CommendAddedEvent($comment));

            $session->getFlashBag()->add('success', 'Thank you! Your comment will be visible after accepting by administrator');
        } else {
            $session->getFlashBag()->add('error', 'Something went wrong during adding your comment. Try again...');
        }

        return $this->redirectToRoute('movie_details', ['id' => $movie->getId()]);
    }
}
