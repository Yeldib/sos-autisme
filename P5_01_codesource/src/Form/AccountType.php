<?php

namespace App\Form;

use App\Entity\ProUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('profilePicture')
            ->add('phoneNumber')
            ->add('jobCategory')
            ->add('address')
            ->add('postalCode')
            ->add('city')
            ->add('department')
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProUser::class,
        ]);
    }
}
