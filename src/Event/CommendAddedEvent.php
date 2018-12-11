<?php declare(strict_types=1);

namespace App\Event;

use App\Entity\Comment;
use Symfony\Component\EventDispatcher\Event;

class CommendAddedEvent extends Event
{
    /**
     * @var Comment
     */
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return Comment
     */
    public function getComment(): Comment
    {
        return $this->comment;
    }
}
