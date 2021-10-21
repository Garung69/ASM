<?php

namespace App\Controller;

use App\Entity\Teacher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    #[Route('/teacher', name: 'teacher_index')]
    public function teacherindex(): Response
    {
       $teachers = $this ->getDoctrine()->getRepository(Teacher::class)->findAll();
       return $this->render(
        'teacher/index.html.twig',
        [
            'teachers' => $teachers
        ]
    );
    }

    #[Route('/teacher/detail/{id}',name:'teacher_detail')]
    public function teacherDetail($id)
    {
        $teacher = $this->getDoctrine()->getRepository(Teacher::class)->find($id);
        if ($teacher == null) {
            $this->addFlash('Error', 'teacher is not existed');
            return $this->redirectToRoute('teacher_index');
        } else {  //$teacher != null
            return $this->render(
                'teacher/detail.html.twig',
                [
                    'teacher' => $teacher
                ]
            );
        }
    }

     /**
     * @Route("/teacher/delete/{id}", name = "teacher_delete")
     */
    public function teacherDelete($id)
    {
        $teacher = $this->getDoctrine()->getRepository(Teacher::class)->find($id);
        if ($teacher == null) {
            $this->addFlash('Error', 'Teacher is not existed');
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($teacher);
            $manager->flush();
            $this->addFlash('Success', 'Teacher has been deleted successfully !');
        }
        return $this->redirectToRoute('teacher_index');
    }


}
