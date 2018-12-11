<?php

namespace App\EventSubscriber;

use App\Event\CommendAddedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NewCommentNotifySubscriber implements EventSubscriberInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }
    
    public static function getSubscribedEvents()
    {
        return [CommendAddedEvent::class => 'sendEmail',
        ];
    }

    public function sendEmail(CommendAddedEvent $event)
    {
        $comment = $event->getComment();
        $message = (new \Swift_Message())
            ->setFrom('krzysztof.jonczyk@gmail.com')
            ->setTo('krzysztof.jonczyk@gmail.com')
            ->setSubject('nowy komentarz od: ' . $comment->getEmail())
            ->setBody(
                $comment->getContent(),
                'text/html'
            );

        $this->mailer->send($message);
    }
}
