<?php

namespace App\DataFixtures;

use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {  
        for ($i=1; $i<=10; $i++) {
            $subject = new Subject();
            $subject->setName("Subject $i");           
            $subject->setDescription("FPT greenwich");
           
            $manager->persist($subject);
        } 
        $manager->flush();
    }
}
