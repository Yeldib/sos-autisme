<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountUserType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                 'firstName',
                 TextType::class,
                 $this->getConfiguration("Prénom", "Modifier votre prénom")
                )
            ->add(
                 'lastName',
                 TextType::class,
                 $this->getConfiguration("Nom", "Modifier votre nom de famille")
                )
            ->add(
                 'email',
                 EmailType::class,
                 $this->getConfiguration("Email", "Modifier votre email")
                )
            ->add(
                 'picture',
                 TextType::class,
                 $this->getConfiguration("Photo de profil", "Modifier ou ajouter l'URL de votre photo",[
                     'required' => false
                 ])
                )
            ->add(
                 'description',
                 TextareaType::class,
                 $this->getConfiguration("Déscription", "Modifier ou ajouter une déscription",[
                     'required' => false
                 ])
                )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
