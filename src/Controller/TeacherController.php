<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Form\TeacherType;
use PhpParser\Node\Name;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/teacher/edit/{id}', name: 'teacher_edit')]
    public function teacherEdit(Request $request ,$id)
    {
        $teacher = $this->getDoctrine()->getRepository(Teacher::class)->find($id);
        $form = $this->createForm(TeacherType::class,$teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($teacher);
            $manager->flush();

            $this->addFlash("Success", "Edit teacher successfully !");
            return $this->redirectToRoute('subject_index');
        }

        return $this->render(
            "teacher/edit.html.twig", 
            [
                "form" => $form->createView()
            ]
        );

    }

    #[Route('/teacher/add', name: 'teacher_add')]
    public function teacherAdd(Request $request)
    {
        $teacher = new Teacher();
        $form = $this->createForm(TeacherType::class,$teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($teacher);
            $manager->flush();

            $this->addFlash("Success", "Add new Teacher successfully !");
            return $this->redirectToRoute('subject_index');
        }

        return $this->render(
            "teacher/add.html.twig", 
            [
                "form" => $form->createView()
            ]
        );
    }


}
