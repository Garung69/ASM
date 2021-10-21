<?php

namespace App\Controller;

use App\Entity\Subject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_USER")
 */
class SubjectController extends AbstractController
{
    #[Route('/subject', name: 'subject_index')]
    public function Subjectindex(): Response
    {
        $subjects = $this->getDoctrine()->getRepository(Subject::class)->findAll();
        return $this->render(
            'subject/index.html.twig',
            [
                'subjects' => $subjects
            ]
        );
    }

    #[Route('/subject/detail/{id}',name:'subject_detail')]
    public function SubjectDetail($id)
    {
        $subject = $this->getDoctrine()->getRepository(Subject::class)->find($id);
        if ($subject == null) {
            $this->addFlash('Error', 'Subject is not existed');
            return $this->redirectToRoute('subject_index');
        } else {  //$subject != null
            return $this->render(
                'subject/detail.html.twig',
                [
                    'subject' => $subject
                ]
            );
        }
    }

    /**
     * @Route("/subject/delete/{id}", name = "subject_delete")
     */
    public function subjectDelete($id)
    {
        $subject = $this->getDoctrine()->getRepository(Subject::class)->find($id);
        if ($subject == null) {
            $this->addFlash('Error', 'Author is not existed');
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($subject);
            $manager->flush();
            $this->addFlash('Success', 'Author has been deleted successfully !');
        }
        return $this->redirectToRoute('subject_index');
    }

    /**
     * @Route("/subject/add", name = "subject_add")
     */
    public function subjectAdd(Request $request){

    }

    /**
     * @Route("/subject/edit/{id}", name = "subject_edit")
     */
    public function subjectEdit(Request $request , $id){
        
    }
}
