<?php

namespace App\DataFixtures;

use App\Entity\Teacher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeacherFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $teacher = new Teacher();
            $teacher->setName("Teacher $i");           
            $teacher->setDob(\DateTime::createFromFormat('Y-m-d','1980-06-08')); 
            $teacher->setEmail("Student $i @gmail.com");  
            $teacher->setPhone("0123456$i");    
            $manager->persist($teacher);
        } 


        $manager->flush();
    }
}
