<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use App\Entity\ToDo;
use App\Entity\Item;

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
    
        // Vérifie si l'exception est levée
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

        // Vérifie si l'exception est levée
        $this->expectException(\RuntimeException::class);

        $todo->addItem($item2);
        
    }

    public function testAddItemWithoutName()
    {
        $todo = new ToDo();
    
        $item1 = new Item();
        $item1->setContent("content");   
        $item1->setCreationDate(new \DateTime());

        // Vérifie si l'exception est levée
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

        // Vérifie si l'exception est levée
        $this->expectException(\RuntimeException::class);

        $todo->addItem($item);
    }

    public function testAddItemWithoutContent()
    {
        $todo = new ToDo();
    
        $item = new Item();
        $item->setName('Item 1');
        $item->setCreationDate(new \DateTime());

        // Vérifie si l'exception est levée
        $this->expectException(\RuntimeException::class);
        
        $todo->addItem($item);
    }

    public function testAddItemWithoutCreationDate()
    {
        $todo = new ToDo();
        $item = new Item();
        $item->setName('Item 1');
        $item->setContent("content");   

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

        // Vérifie si l'exception est levée
        $this->expectException(\RuntimeException::class);

        $todo->addItem($item2);
    }
}
