<?php

namespace App\Form;

use App\Entity\Student;
use App\Entity\Subject;
use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType :: class,
            [
                'required'=>true,  // k dc null
                'label' =>"Student Name"
            ])
            ->add('dob',DateType::class,
            [
                'label'=>"DOB",
                'widget'=>'single_text'
            ])
            ->add('location',TextType :: class,
            [
                'required'=>true,
                'label' =>"Location"
            ])
            ->add('major',TextType :: class,
            [
                'required'=>true,
                'label' =>"Major"
            ])
            ->add('image',FileType:: class,
            [
                'label'=>"Image",
                'data_class'=> null, 
                'required' => false
            ])
            ->add('email',TextType :: class,
            [
                'required'=>true,
                'label' =>"Email"
            ])
            ->add('phone',TextType :: class,
            [
                'required'=>true,
                'label' =>"PhoneNumber"
            ])
            ->add('subjects',EntityType::class,
            [
                'label'=>"Subject",
                'class'=> Subject::class,
                'choice_label'=>"name",
                'multiple'=>True, // chon nhieu
                'expanded'=>false,// dropdown / true: checkbok
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
