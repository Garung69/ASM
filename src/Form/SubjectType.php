<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Subject;
use App\Entity\Teacher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class SubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,
            [
                'label'=>"Subject Name",
                'required'=>true
            ])
            ->add('description',TextType::class,
            [
                'label'=> "Description",
                'required'=>true
            ])
            // ->add('student')
            ->add('category',EntityType::class,
            [
                'label'=>"Category",
                'class'=> Category::class,
                'choice_label'=>"name",
                'multiple'=>false, // chi chon 1
                'expanded'=>false,// dropdown / true: checkbok
            ])
            ->add('teacher',EntityType::class,
            [
                'label'=>"Teacher",
                'class'=> Teacher::class,
                'choice_label'=>"name",
                'multiple'=>false, // chi chon 1
                'expanded'=>false,// dropdown / true: checkbok
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Subject::class,
        ]);
    }
}
