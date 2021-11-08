<?php

namespace App\Services;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class EmailSender
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(UserInterface $user, string $title, string $templateMessage): void
    {
        $email = (new TemplatedEmail())
            ->from('noreply@snowtricks.com')
            ->to($user->getEmail())
            ->subject($title)
            ->htmlTemplate($templateMessage)
        ;

        $context = $email->getContext();
        $context['signedUrl'] = 'https://snowtricks.wip/verify/email/';
        $context['user'] = $user;

        $email->context($context);

        $this->mailer->send($email);
    }
}