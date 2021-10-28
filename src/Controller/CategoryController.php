<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class CategoryController extends AbstractController
{
    /**
    * @IsGranted("ROLE_USER")
    */
    #[Route('/category', name: 'category_index')]
    public function categoryIndex(){
        $categories = $this ->getDoctrine()->getRepository(Category :: class)->findAll();
        return $this ->render(
            'category/index.html.twig',
            [
                'categories' => $categories
            ]
            );
    }
    /**
    * @IsGranted("ROLE_USER")
    */
    #[Route('/category/detail/{id}',name:'category_detail')]
    public function categoryDetail($id){
        $category = $this->getDoctrine()->getRepository(Category :: class)->find($id);
        if ($category == null) {
            $this->addFlash('Error', 'Category is not existed');
            return $this->redirectToRoute('category_index');
        } else {  //$subject != null
            return $this->render(
                'category/detail.html.twig',
                [
                    'category' => $category
                ]
            );
        }
    }
    /**
    * @IsGranted("ROLE_ADMIN")
    */
    #[Route('/category/delete/{id}', name:'category_delete')]
    public function categoryDelete($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
       
             if ($category == null) {
            $this->addFlash('Error', 'CAtegory is not existed');
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($category);
            $manager->flush();
            $this->addFlash('Success', 'Category has been deleted successfully !');
        }
        
        return $this->redirectToRoute('category_index');
    }

    /**
    * @IsGranted("ROLE_ADMIN")
    */
    #[Route('/category/edit/{id}',name:'category_edit')]
    public function categoryEdit(Request $request,$id){
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();

            $this->addFlash("Success", "Edit category successfully !");
            return $this->redirectToRoute('category_index');
        }

        return $this->render(
            "category/edit.html.twig", 
            [
                "form" => $form->createView()
            ]
        );

    }


    /**
    * @IsGranted("ROLE_ADMIN")
    */
    #[Route('/category/add',name:'category_add')]
    public function categoryAdd(Request $request){
        $category = new Category();
        $form = $this->createForm(CategoryType::class,$category);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();

            $this->addFlash("Success", "Add new Category successfully !");
            return $this->redirectToRoute('category_index');
        }
        return $this->render(
            "category/add.html.twig", 
            [
                "form" => $form->createView()
            ]
        );
    }
}
