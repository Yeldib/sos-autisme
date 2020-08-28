<?php

namespace App\Form;

use App\Entity\ProUser;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AccountProUserType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'lastName',
                TextType::class,
                $this->getConfiguration("Nom", "Indiquez votre nom")
            )
            ->add(
                 'firstName',
                 TextType::class,
                 $this->getConfiguration("Prénom", "Indiquez votre Prénom")
                )
            ->add(
                 'email',
                 EmailType::class, 
                 $this->getConfiguration("Email", "Indiquez votre adresse email")
                )
            ->add(
                 'picture', 
                 UrlType::class, 
                 $this->getConfiguration("Photo de profil", "Renseignez une url pour votre photo (facultatif)", 
                 ['required' => false])
                )
            ->add(
                 'phoneNumber', 
                 TextType::class, 
                 $this->getConfiguration("Numéro de télephone", "Indiquez votre numéro ici")
                )
            ->add(
                 'jobCategory', 
                 TextType::class, 
                 $this->getConfiguration("Métier", "Votre métier")
                )
            ->add(
                 'address', 
                 TextType::class, 
                 $this->getConfiguration("Adresse", "Indiquez votre adresse")
                )
            ->add(
                 'postalCode', 
                 TextType::class, 
                 $this->getConfiguration("Code postal", "Indiquez votre code postal")
                )
            ->add(
                 'city', 
                 TextType::class, 
                 $this->getConfiguration("Ville", "Indiquez votre ville")
                )
            ->add(
                 'department', 
                 TextType::class, 
                 $this->getConfiguration("Département", "Indiquez votre département")
                )
            ->add(
                 'description', 
                 TextareaType::class, 
                 $this->getConfiguration("Déscription", "Vous décrire (non obligatoire)", 
                 ['required' => false])
                )
            ->add(
                 'companySiret', 
                 TextType::class, 
                 $this->getConfiguration("SIRET", "Indiquez votre numéro SIRET")
                );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProUser::class,
        ]);
    }
}
