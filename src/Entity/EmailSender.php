<?php
namespace App\Entity;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportException;

class EmailSender
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(string $recipient, string $subject, string $content): bool
    {
        $email = (new Email())
            ->from('fernandesamilcar28@gmail.com')
            ->to($recipient)
            ->subject($subject)
            ->text($content);

        try {
            $this->mailer->send($email);
            return true;
        } catch (TransportException $e) {
            // Une erreur s'est produite lors de l'envoi du courrier électronique
            return false;
        }
    }
}