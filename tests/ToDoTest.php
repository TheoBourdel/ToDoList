<?php

namespace App\Tests;

use App\Entity\EmailSenderService;
use App\Repository\EmailSenderServiceRepository;
use App\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use App\Entity\ToDo;
use App\Entity\Item;
use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\EmailSender;

class ToDoTest extends TestCase
{
    public function testAddItemMaxLimit()
    {
        $todo = new ToDo();
        $creationDate = new \DateTime();

        for ($i = 1; $i <= 10; $i++) {
            $item = new Item();
            $item->setName("Item $i");
            $item->setContent("content $i");
            $item->setCreationDate(clone $creationDate);
            $todo->addItem($item);
            $creationDate->add(new \DateInterval('PT30M'));

        }
    
        // Vérifie si l'exception est levée (assert)
        $this->expectException(\RuntimeException::class);
    
        $item = new Item();
        $item->setName("Item 11");
        $item->setContent("content 11");
        $item->setCreationDate(clone $creationDate); 
    
        $todo->addItem($item);
    }

    public function testAddItemWithDuplicateName()
    {
        $todo = new ToDo();
        $creationDate = new \DateTime();
    
        $item1 = new Item();
        $item1->setName('Item 1');
        $item1->setContent("content");
        $item1->setCreationDate($creationDate);
        $todo->addItem($item1);
    
        $creationDate->add(new \DateInterval('PT30M'));
    
        $item2 = new Item();
        $item2->setName('Item 1');
        $item2->setContent("content");
        $item2->setCreationDate($creationDate);

        // Vérifie si l'exception est levée (assert)
        $this->expectException(\RuntimeException::class);

        $todo->addItem($item2);
        
    }

    public function testAddItemWithoutName()
    {
        $todo = new ToDo();
    
        $item1 = new Item();
        $item1->setContent("content");   
        $item1->setCreationDate(new \DateTime());

        // Vérifie si l'exception est levée (assert)
        $this->expectException(\RuntimeException::class);

        $todo->addItem($item1);
    }

    public function testAddItemWithLongContent()
    {
        $todo = new ToDo();

        $item = new Item();
        $item->setName('Item 1');
        $item->setContent(str_repeat("A", 1001)); 
        $item->setCreationDate(new \DateTime());

        // Vérifie si l'exception est levée (assert)
        $this->expectException(\RuntimeException::class);

        $todo->addItem($item);
    }

    public function testAddItemWithoutContent()
    {
        $todo = new ToDo();
    
        $item = new Item();
        $item->setName('Item 1');
        $item->setCreationDate(new \DateTime());

        // Vérifie si l'exception est levée (assert)
        $this->expectException(\RuntimeException::class);
        
        $todo->addItem($item);
    }

    public function testAddItemWithoutCreationDate()
    {
        $todo = new ToDo();
        $item = new Item();
        $item->setName('Item 1');
        $item->setContent("content");  
        
        // Vérifie si l'exception est levée (assert)
        $this->expectException(\RuntimeException::class);

        $todo->addItem($item);
    }

    public function testAddItemWithInterval()
    {
        $todo = new ToDo();

        $item1 = new Item();
        $item1->setName('Item 1');
        $item1->setContent('content');
        $item1->setCreationDate(new \DateTime());
        $todo->addItem($item1);

        $item2 = new Item();
        $item2->setName('Item 2');
        $item2->setContent('content'); 
        $item2->setCreationDate(new \DateTime());

        // Vérifie si l'exception est levée (assert)
        $this->expectException(\RuntimeException::class);

        $todo->addItem($item2);
    }

    public function testUserInvalid()
    {
        $user = new User();
        $user->setEmail('invalid-email');
        $user->setFirstName('');
        $user->setLastName('Doe');
        $user->setPassword('password');
        $user->setBirthdate(new \DateTime('-10 years'));

        $todo = new ToDo();

        $item1 = new Item();
        $item1->setName('Item 1');
        $item1->setContent('content');
        $item1->setCreationDate(new \DateTime());
        $todo->addItem($item1);

        /// Vérifie si l'exception est levée (assert)
        $this->expectException(\RuntimeException::class);

        $isValid = $user->isValid();
    }

    public function testSendingEmailTrue()
    {
        $user = new User();
        $user->setEmail('fernandesamilcar28@gmail.com');

        // Instanciation de la classe EmailSendingClass avec le mock du MailerInterface
        $emailSenderService = new EmailSenderService();
        $emailSenderService
            ->setRecipent($user)
            ->setObject("test object")
            ->setContent("test content");

        $this->assertTrue($emailSenderService->testSendingEmail());
    }

    public function testSendingEmailWithoutObject()
    {
        $user = new User();
        $user->setEmail('fernandesamilcar28@gmail.com');

        // Instanciation de la classe EmailSendingClass avec le mock du MailerInterface
        $emailSenderService = new EmailSenderService();
        $emailSenderService
            ->setRecipent($user)
            ->setObject('')
            ->setContent("test content");

        $this->assertFalse($emailSenderService->testSendingEmail());
    }

    public function testSendingEmailWithoutContent()
    {
        $user = new User();
        $user->setEmail('fernandesamilcar28@gmail.com');

        // Instanciation de la classe EmailSendingClass avec le mock du MailerInterface
        $emailSenderService = new EmailSenderService();
        $emailSenderService
            ->setRecipent($user)
            ->setObject("test object")
            ->setContent('');

        $this->assertFalse($emailSenderService->testSendingEmail());
    }

    public function testSendingEmailWithoutRecipient()
    {
        $user = new User();
        $user->setEmail('');

        // Instanciation de la classe EmailSendingClass avec le mock du MailerInterface
        $emailSenderService = new EmailSenderService();
        $emailSenderService
            ->setRecipent($user)
            ->setObject("test object")
            ->setContent("test content");

        $this->assertFalse($emailSenderService->testSendingEmail());
    }
}
