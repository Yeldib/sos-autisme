<?php

namespace App\Form;

use App\Entity\Contact;
use App\Form\ApplicationType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                 'firstName',
                 TextType::class,
                 $this->getConfiguration('Prénom', "Votre prénom")
                )
            ->add(
                 'lastName',
                 TextType::class,
                 $this->getConfiguration('Nom', "Votre Nom")
                )
            ->add(
                 'phone',
                 TextType::class,
                 $this->getConfiguration('Télephone', "Votre Numéro de télephone")
                )
            ->add(
                 'email',
                 EmailType::class,
                 $this->getConfiguration('Email', "Votre adresse email")
                )
            ->add(
                 'message',
                 TextareaType::class,
                 $this->getConfiguration('Votre message', "Tapez votre message")
                )
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
