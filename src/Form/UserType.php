<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class)
            ->add('password',RepeatedType::class,[
                'type' => PasswordType::class,
                'first_options' => ['label'=> 'Password'],
                'second_options' => ['label' => 'Confirm_Password']
            ])
            ->add('birth_date')
            ->add('firstname',TextType::class)
            ->add('lastname',TextType::class)
            ->add('phone')
            ->add('adress')
            ->add('nationality',TextType::class)
            ->add('gender',TextType::class)
            ->add('profileImage')
            ->add('profile')
            ->add('activities')
            ->add('manager')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
