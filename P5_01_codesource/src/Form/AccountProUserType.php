<?php

namespace App\Form;

use App\Entity\ProUser;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                 ChoiceType::class,[ 
                    'label' => "Selectionnez votre métier",
                    'placeholder' => "-- liste --",                  
                    'choices'   => [                       
                        'Orthophoniste'    => 'Orthophoniste',
                        'Pédopsychiatre'   =>   'Pédopsychiatre',
                        'Éducateur(trice) spécialisé(e)' => 'Éducateur(trice) spécialisé(e)',
                        'Psychomotricien(ne)' => 'Psychomotricien(ne)',
                        'Psychologue' => 'Psychologue'
                    ]                     
                ])
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
                ChoiceType::class,[
                    'label' => "Selectionnez votre département", 
                    'placeholder' => "-- Selectionnez votre département --",
                    'choices'   => [
                        '01 - AIN' => '01', 
                        '02 - AISNE' => '02',
                        '03 - ALLIER' => '03',
                        '04 - ALPES DE HAUTE PROVENCE' => '04',
                        '05 - HAUTES - ALPES' => '05',
                        '06 - ALPES MARITIMES' => '06',
                        '07 - ARDECHE' => '07',
                        '08 - ARDENNES' => '08',
                        '09 - ARIEGE'=> '09',
                        '10 - AUBE'=> '10',
                        '11 - AUDE'=> '11',
                        '12 - AVEYRON'=> '12',
                        '13 - BOUCHES - DU - RHONE'=> '13',
                        '14 - CALVADOS'=> '14',
                        '15 - CANTAL'=> '15',
                        '16 - CHARENTE'=> '16',
                        '17 - CHARENTE - MARITIME'=> '17',
                        '18 - CHER'=> '18',
                        '19 - CORREZE'=> '19',
                        '21 - COTE - D\'OR'=> '21',
                        '22 - COTES D\'ARMOR'=> '22',
                        '23 - CREUSE'=> '23',
                        '24 - DORDOGNE'=> '24',
                        '25 - DOUBS'=> '25',
                        '26 - DROME'=> '26',
                        '27 - EURE'=> '27',
                        '28 - EURE - ET - LOIR'=> '28',
                        '29 - FINISTERE'=> '29',
                        '2A - CORSE du SUD'=> '2A',
                        '2B - HAUTE CORSE'=> '2B',
                        '30 - GARD'=> '30',
                        '31 - HAUTE - GARONNE'=> '31',
                        '32 - GERS'=> '32',
                        '33 - GIRONDE'=> '33',
                        '34 - HERAULT'=> '34',
                        '35 - ILLE - ET - VILAINE'=> '35',
                        '36 - INDRE'=> '36',
                        '37 - INDRE - ET - LOIRE'=> '37',
                        '38 - ISERE'=> '38',
                        '39 - JURA'=> '39',
                        '40 - LANDES'=> '40',
                        '41 - LOIR - ET - CHER'=> '41',
                        '42 - LOIRE'=> '42',
                        '43 - HAUTE - LOIRE'=> '43',
                        '44 - LOIRE - ATLANTIQUE' => '44',       
                        '45 - LOIRET'=> '45',
                        '46 - LOT'=> '46',
                        '47 - LOT - ET - GARONNE'=> '47',
                        '48 - LOZERE'=> '48',
                        '49 - MAINE et LOIRE'=> '49',
                        '50 - MANCHE'=>  '50',
                        '51 - MARNE'=> '51',
                        '52 - HAUTE - MARNE'=> '52',
                        '53 - MAYENNE'=> '53',
                        '54 - MEURTHE - ET - MOSELLE'=> '54',
                        '55 - MEUSE'=> '55',
                        '56 - MORBIHAN'=> '56',
                        '57 - MOSELLE'=> '57',
                        '58 - NIEVRE'=> '58',
                        '59 - NORD'=> '59',
                        '60 - OISE'=> '60',
                        '61 - ORNE'=> '61',
                        '62 - PAS - DE - CALAIS'=> '62',
                        '63 - PUY - DE - DOME'=> '63',
                        '64 - PYRENNES - ATLANTIQUES'=> '64',
                        '65 - HAUTES - PYRENNES'=> '65',
                        '66 - PYRENNES - ORIENTALES'=> '66',
                        '67 - BAS - RHIN'=> '67',
                        '68 - HAUT - RHIN'=> '68',
                        '69 - RHONE'=> '69',
                        '70 - HAUTE - SAONE'=> '70',
                        '71 - SAONE - ET - LOIRE'=> '71',
                        '72 - SARTHE'=> '72',
                        '73 - SAVOIE'=> '73',
                        '74 - HAUTE - SAVOIE'=> '74',
                        '75 - PARIS'=> '75',
                        '76 - SEINE - MARITIME'=> '76',
                        '77 - SEINE - ET - MARNE'=> '77',
                        '78 - YVELINES'=> '78',
                        '79 - DEUX SEVRES'=> '79',
                        '80 - SOMME'=> '80',
                        '81 - TARN'=> '81',
                        '82 - TARN - ET - GARONNE'=> '82',
                        '83 - VAR'=> '83',
                        '84 - VAUCLUSE'=> '84',
                        '85 - VENDEE'=> '85',
                        '86 - VIENNE'=> '86',
                        '87 - HAUTE - VIENNE'=> '87',
                        '88 - VOSGES'=> '88',
                        '89 - YONNE'=> '89',
                        '90 - TERRITOIRE DE BELFORT'=> '90',
                        '91 - ESSONNE'=> '91',
                        '92 - HAUTS - DE - SEINE'=> '92',
                        '93 - SEINE - SAINT - DENIS'=> '93',
                        '94 - VAL - DE - MARNE'=> '94',
                        '95 - VAL - D\'OISE'=> '95',
                        '971 - GUADELOUPE'=> '971',
                        '972 - MARTINIQUE'=> '972',
                        '973 - GUYANE'=> '973',
                        '974 - REUNION'=> '974',
                        '975 - ST PIERRE et MIQUELON'=> '975'
                    ]
                ])
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
