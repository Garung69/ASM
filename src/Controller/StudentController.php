<?php

namespace App\Controller;

use App\Entity\Student;
use PhpParser\Node\Name;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'student_index')]
    public function studentindex(): Response
    {
       $students = $this ->getDoctrine()->getRepository(Student::class)->findAll();
       return $this->render(
        'student/index.html.twig',
        [
            'students' => $students
        ]
    );
    }

    #[Route('/student/detail/{id}',name:'student_detail')]
    public function studentDetail($id)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        if ($student == null) {
            $this->addFlash('Error', 'Student is not existed');
            return $this->redirectToRoute('student_index');
        } else {  //$Student != null
            return $this->render(
                'student/detail.html.twig',
                [
                    'student' => $student
                ]
            );
        }
    }

     /**
     * @Route("/student/delete/{id}", name = "student_delete")
     */
    public function studentDelete($id)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        if ($student == null) {
            $this->addFlash('Error', 'student is not existed');
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($student);
            $manager->flush();
            $this->addFlash('Success', 'Student has been deleted successfully !');
        }
        return $this->redirectToRoute('student_index');
    }

    #[Route('/student/edit/{id}', name: 'student_edit')]
    public function studentEdit(Request $request ,$id)
    {

    }

    #[Route('/student/add', name: 'student_add')]
    public function studentAdd(Request $request)
    {
        
    }


}
