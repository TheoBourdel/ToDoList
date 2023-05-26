<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\EmailSender;


#[ORM\Entity(repositoryClass: EmailSenderServiceRepository::class)]
class EmailSenderService extends TestCase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'emailSenderServices')]
    private ?User $recipent = null;

    #[ORM\Column(length: 255)]
    private ?string $object = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getRecipent(): ?User
    {
        return $this->recipent;
    }

    public function setRecipent(?User $recipent): self
    {
        $this->recipent = $recipent;

        return $this;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(string $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function testSendingEmail() : bool
    {

        //mock avec MailerInterface
        $mailerMock = $this->getMockBuilder(MailerInterface::class)
            ->getMock();

        // Définissez les attentes pour la méthode send()
        $mailerMock->expects($this->once())
            ->method('send')
            ->with(
                $this->isInstanceOf(Email::class)
            );

        // Instanciation de la classe EmailSender avec le mock du MailerInterface
        $emailSender = new EmailSender($mailerMock);

        $recipientMail = $this->getRecipent()->getEmail();
        $object = $this->getObject();
        $content = $this->getContent();

        if(empty($content) || empty($object) || empty($recipientMail))
            return false;

        // Appelez la méthode de la classe sous test
        return $emailSender->sendEmail($recipientMail, $object, $content);
    }
}
