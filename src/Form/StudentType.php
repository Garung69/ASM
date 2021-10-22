<?php

namespace App\Form;

use App\Entity\Student;
use App\Entity\Subject;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
                'lable' =>"Student Name"
            ])
            ->add('dob',DateType::class,
            [
                'label'=>"DOB",
                'widget'=>'single_text'
            ])
            ->add('location',TextType :: class,
            [
                'required'=>true,
                'lable' =>"Location"
            ])
            ->add('major',TextType :: class,
            [
                'required'=>true,
                'lable' =>"Major"
            ])
            ->add('image',FileType:: class,
            [
                'label'=>"Image",
                'data_class'=> null, 
                'required' => is_null($builder->getData()->getImage())
            ])
            ->add('email',TextType :: class,
            [
                'required'=>true,
                'lable' =>"Email"
            ])
            ->add('phone',TextType :: class,
            [
                'required'=>true,
                'lable' =>"PhoneNumber"
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
