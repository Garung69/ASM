<?php

namespace App\Controller;

use App\Entity\Student;
use PhpParser\Node\Name;
use App\Form\StudentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use function PHPUnit\Framework\throwException;

class StudentController extends AbstractController
{
    /**
    * @IsGranted("ROLE_USER")
    */
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
    /**
   * @IsGranted("ROLE_USER")
    */
    #[Route('/student/detail/{id}',name:'student_detail')]
    public function studentDetail($id)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        if ($student == null) {
            $this->addFlash('Error', 'Student is not existed');
            return $this->redirectToRoute('student_index');
        } 
        else {  //$Student != null
            return $this->render(
                'student/detail.html.twig',
                [
                    'student' => $student
                ]
            );
        }
    }

     /**
      * @IsGranted("ROLE_ADMIN")
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





    #[Route('/student/add', name: 'student_add')]
    public function studentAdd(Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $avata = $student->getImage();
            $avtName = uniqid();
            $avataExtension = $avata->guessExtension();
            $avataName = $avtName . "." .$avataExtension;
            try{
                $avata->move(
                    $this->getParameter('student_image'),$avataName
                );
            }
            catch(FileException $e){
                throwException($e);
            }
            $student ->setImage($avataName);
            
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($student);
            $manager->flush();


            $this->addFlash('Success',"ADD new student successfully");
            return $this->redirectToRoute("student_index"); 
        }
            return $this->render(
                "student/add.html.twig",
                [
                    "form"=> $form->createView()
                ]
            );
        
        
    }
        

    #[Route('/student/edit/{id}', name: 'student_edit')]
    public function studentEdit(Request $request ,$id)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $file = $form['image']->getData();

            if($file != null){
                  $avata = $student->getImage();
                $avtName = uniqid();
                $avataExtension = $avata->guessExtension();
                $avataName = $avtName . "." .$avataExtension;
                try{
                    $avata->move(
                        $this->getParameter('student_image'),$avataName
                    );
                }
                catch(FileException $e){
                    throwException($e);
                }
                $student ->setImage($avataName);
            }

          
            
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($student);
            $manager->flush();
            $this->addFlash('Success',"Edit student successfully");
            return $this->redirectToRoute("student_index"); 
        }

            return $this->render(
                "student/add.html.twig",
                [
                    "form"=> $form->createView()
                ]
            );

    }
    



}
