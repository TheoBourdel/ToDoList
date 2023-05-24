<?php

namespace App\Tests;

use App\Entity\User;
use Faker\Core\DateTime;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testIsValidWithValidUser()
    {
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setPassword('Password1');
        $user->setBirthdate(new \DateTime('-20 years'));

        $isValid = $user->isValid();

        $this->assertTrue($isValid);
    }

    public function testIsValidWithInvalidUser()
    {
        $user = new User();
        $user->setEmail('invalid-email');
        $user->setFirstName('');
        $user->setLastName('Doe');
        $user->setPassword('password');
        $user->setBirthdate(new \DateTime('-10 years'));

        $isValid = $user->isValid();

        $this->assertFalse($isValid);
    }
}

