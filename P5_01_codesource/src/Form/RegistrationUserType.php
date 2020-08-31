<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationUserType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'pseudo',
                TextType::class, 
                $this->getConfiguration("Pseudonyme", "Indiquez un pseudonyme")
                )
            ->add(
                'lastName',
                TextType::class, 
                $this->getConfiguration("Nom", "Indiquez votre nom")
                )
            ->add(
                 'firstName', 
                 TextType::class, 
                 $this->getConfiguration("Prénom", "Indiquez votre prénom")
                )
            ->add(
                 'email',
                 EmailType::class,
                 $this->getConfiguration("Email", "Indiquez votre adresse email")
                )
            ->add(
                 'picture',
                 TextType::class,
                 $this->getConfiguration("Photo de profil", "Renseignez une url pour votre photo (facultatif)", [
                    'required' => false
                ])
                )
            ->add(
                 'hash',
                 PasswordType::class,
                 $this->getConfiguration("Mot de passe", "Votre mot de passe doit contenir au moins 8 caratcères.")
                )
            ->add(
                'passwordConfirm', 
                PasswordType::class, 
                $this->getConfiguration("Confirmation de mot de passe", "Merci de confirmer votre mot de passe") 
                )
            ->add(
                 'description',
                 TextareaType::class,
                 $this->getConfiguration("Déscription", "Vous décrire (non obligatoire)", [
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
