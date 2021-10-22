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
    //     $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
    //     $form = $this->createForm(StudentType::class, $student);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $file = $form['image']->getData();
    //         //code xử lý việc upload ảnh
    //         //B1: lấy ảnh từ file upload
    //         if ($file != null) {
    //         $image = $student->getImage();
    //         //B2: đặt tên mới cho ảnh => đảm bảo mỗi ảnh sẽ có 1 tên duy nhất không trùng nhau
    //         $imgName = uniqid(); //unique id
    //         //B3: lấy đuôi ảnh (image extension)
    //         $imgExtension = $image->guessExtension();
    //         //B4: nối tên và đuôi để tạo thành tên file ảnh mới đầy đủ
    //         $imageName = $imgName . "." . $imgExtension;
    //         //B5: di chuyển ảnh vào thư mục chỉ định
    //         try {
    //             $image->move(
    //                 $this->getParameter('student_image'),
    //                 $imageName
    //                 //Lưu ý: cần khai báo đường dẫn thư mục chứa ảnh
    //                 //ở file config/services.yaml
    //             );
    //         } catch (FileException $e) {
    //             //throwException($e);
    //         }
    //         //B6: lưu tên ảnh vào database
    //         $student->getImage($imageName);

    //         //đẩy dữ liệu nhập từ form vào database
    //         $manager = $this->getDoctrine()->getManager();
    //         $manager->persist($student);
    //         $manager->flush();

    //         //hiển thị thông báo và chuyển hướng website
    //         $this->addFlash('Success', "edit student successfully !");
    //         return $this->redirectToRoute("student_index");
    //     }
    // }
    //     return $this->render(
    //         "student/edit.html.twig",
    //         [
    //             "form" => $form->createView()
    //         ]
    //     );
        

    }













    #[Route('/student/add', name: 'student_add')]
    public function studentAdd(Request $request)
    {
        // $student = new Student();
        // $form = $this->createForm(StudentType::class, $student);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     //code xử lý việc upload ảnh
        //     //B1: lấy ảnh từ file upload
        //     $image = $student->getImage();
        //     //B2: đặt tên mới cho ảnh => đảm bảo mỗi ảnh sẽ có 1 tên duy nhất không trùng nhau
        //     $imgName = uniqid(); //unique id
        //     //B3: lấy đuôi ảnh (image extension)
        //     $imgExtension = $image->guessExtension();
        //     //B4: nối tên và đuôi để tạo thành tên file ảnh mới đầy đủ
        //     $imageName = $imgName . "." . $imgExtension;
        //     //B5: di chuyển ảnh vào thư mục chỉ định
        //     try {
        //         $image->move(
        //             $this->getParameter('student_image'),
        //             $imageName
        //             //Lưu ý: cần khai báo đường dẫn thư mục chứa ảnh
        //             //ở file config/services.yaml
        //         );
        //     } catch (FileException $e) {
        //         //throwException($e);
        //     }
        //     //B6: lưu tên ảnh vào database
        //     $student->getImage($imageName);

        //     //đẩy dữ liệu nhập từ form vào database
        //     $manager = $this->getDoctrine()->getManager();
        //     $manager->persist($student);
        //     $manager->flush();

        //     //hiển thị thông báo và chuyển hướng website
        //     $this->addFlash('Success', "Add new student successfully !");
        //     return $this->redirectToRoute("student_index");
        // }

        // return $this->render(
        //     "student/add.html.twig",
        //     [
        //         "form" => $form->createView()
        //     ]
        // );
        
    }


}
