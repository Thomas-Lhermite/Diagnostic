<?php

namespace App\DataFixtures;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

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
        $user->setEmail('demo@gmail.com');
        $password = $this->hasher->hashPassword($user, 'demo');
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $admin = new User();
        $admin->setEmail('demo2@gmail.com');
        $password = $this->hasher->hashPassword($admin, 'demo');
        $admin->setPassword($password);
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);


        $manager->flush();
    }
}
