<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setUsername('Toto')
            ->setEmail('floryss.devweb+10@gmail.com')
            ->setPassword($this->hasher->hashPassword($user, 'secret'))
            ->setIsVerified(true)
        ;

        $manager->persist($user);
        $manager->flush();
    }
}
