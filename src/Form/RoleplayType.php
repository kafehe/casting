<?php

namespace App\Form;

use App\Entity\Roleplay;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoleplayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title_role')
            ->add('firstname_role')
            ->add('lastname_role')
            ->add('range_age')
            ->add('description_role')
            ->add('gender_role')
            ->add('actitvitiesTodo')
            ->add('casting');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Roleplay::class,
        ]);
    }
}