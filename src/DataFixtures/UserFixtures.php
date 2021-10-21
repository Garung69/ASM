<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class UserFixtures extends Fixture
{
    private $hasher;
    public function __construct (UserPasswordHasherInterface $hasher){
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername("user");
        $user->setPassword($this->hasher->hashpassword($user, "12345"));
        $user->setRoles(["ROLE_USER"]);
        $manager->persist($user);

        $staff = new User();
        $staff->setUsername("staff");
        $staff->setPassword($this->hasher->hashpassword($user, "12345"));
        $staff->setRoles(["ROLE_ADMIN"]);
        $manager->persist($staff);

        $manager->flush();
    }
}
