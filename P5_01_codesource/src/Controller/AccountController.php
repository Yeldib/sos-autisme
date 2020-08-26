<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\ProUser;
use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\PasswordUpdateType;
use App\Form\RegistrationUserType;
use App\Form\RegistrationUserProType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * Permet d'afficher et de gérer le formulaire de connexion
     * 
     * @Route("/login", name="account_login")
     * 
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * Permet de se déconnecter
     * 
     * @Route("/logout", name="account_logout")
     *
     * @return void
     */
    public function logout()
    {
        # deconnexion
    }

    /**
     * Permet d'afficher le formulaire d'inscription pour un professionnel
     * 
     * @Route("/pro-register", name="account_register_pro")
     *
     * @return Response
     */
    public function registerPro(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $proUser = new ProUser();

        $form = $this->createForm(RegistrationUserProType::class, $proUser);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($proUser, $proUser->getHash());
            $proUser->setHash($hash);

            $manager->persist($proUser);
            $manager->flush();

            $this->addFlash(
                'success',
                "Merci pour votre inscription."
            );

            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/registerPro.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'inscription pour un utilisateur
     * 
     * @Route("/register", name="account_register")
     *
     * @return Response
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(RegistrationUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte a bien été crée."
            );

            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher et de traiter le formulaire de modification du profil
     * 
     * @Route("/account/profile", name="account_profile")
     * @Security("is_granted('ROLE_USER') or is_granted('ROLE_PRO_USER')")
     *
     * @return Response
     */
    public function profile(Request $request, EntityManagerInterface $manager)
    {
        $proUser = $this->getUser(); //  On vérifie si l'utilisateur est connecté

        $form = $this->createForm(AccountType::class, $proUser);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($proUser);
            $manager->flush();

            $this->addFlash(
                'success',
                "Vos modifications on bien été enregistrée."
            );
        }

        return $this->render('account/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de mofifier le mot de passe
     * 
     * @Route("/account/password-update", name="account_password")
     * @Security("is_granted('ROLE_USER') or is_granted('ROLE_PRO_USER')")
     *
     * @return Response
     */
    public function updatePassword(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $passwordUpdate = new PasswordUpdate();

        $proUser = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 1. Vérifier si le oldpassword du formulaire soit identique au password de l'utilisateur
            if (!password_verify($passwordUpdate->getOldPassword(), $proUser->getHash())) {
                // Gestion de l'erreur
                $form->get('oldPassword')->addError(new FormError("Le mot de passe indiqué n'est pas votre mot de passe actuel."));
            }else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($proUser, $newPassword);

                $proUser->setHash($hash);
                $manager->persist($proUser);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Votre mot de passe a bien été modifié."
                );

                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher le profil de l'utilisateur connecté
     * 
     * @Route("/account", name="account_index")
     * Security("is_granted('ROLE_USER') or is_granted('ROLE_PRO_USER')")
     *
     * @return Response
     */
    public function myAccount()
    {
        return $this->render('user/indexAccount.html.twig', [
            'proUser' => $this->getUser(),
        ]);
    }
}
