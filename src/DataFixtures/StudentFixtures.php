<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Student;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $student = new Student();
            $student->setName("Student $i");           
            $student->setDob(\DateTime::createFromFormat('Y-m-d','1980-06-08')); 
            $student->setEmail("Student $i @gmail.com");  
            $student->setMajor("Spring");   
            $student->setLocation("ha noi");
            $student->setPhone("0123456$i");    
            $manager->persist($student);
        } 

        $manager->flush();
    }
}
