<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ModerationController extends AbstractController
{
    /**
     * {@inheritdoc}
     * @Route("/moderation/{page}", name="moderation_list", defaults={"page"=1})
     */
    public function list(EntityManagerInterface $entityManager, PaginatorInterface $paginator, $page = 1): Response
    {
        $commentsToModerateQuery = $entityManager->getRepository(Comment::class)->getNew();
        $pagination = $paginator->paginate($commentsToModerateQuery, $page);

        return $this->render('Moderation/list.html.twig', ['pagination' => $pagination]);
    }

    /**
     * {@inheritdoc}
     * @Route("/moderation/comment/{id}/{status}", name="moderation_change_status", methods={"POST"})
     */
    public function changeStatus(
        EntityManagerInterface $entityManager,
        Session $session,
        Comment $comment,
        string $status
    ): RedirectResponse
    {
        if (false === in_array($status, Comment::STATUSES)) {
            $session->getFlashBag()->add('error', 'Incorrect status, use accepted or rejected only!');

            return $this->redirectToRoute('moderation_list');
        }

        $comment->setStatus($status);
        $entityManager->persist($comment);
        $entityManager->flush();

        $session->getFlashBag()->add('success', "Comment has been {$status}");

        return $this->redirectToRoute('moderation_list');
    }
}
