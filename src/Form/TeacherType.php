<?php

namespace App\Form;

use App\Entity\Teacher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeacherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,
            [
                'label'=> "Teacher Name",
                'required'=>true
            ])
            ->add('email',TextType:: class,
            [
                'label'=>"Teacher Email",
                'required'=> true
            ])
            ->add('phone',TextType::class,
            [
                'label'=> "Teacher PhoneNumber",
                'required'=>true
            ])
            ->add('dob',DateType::class,
            [
                'label'=>"DOB",
                'widget'=>'single_text'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class,
        ]);
    }
}
