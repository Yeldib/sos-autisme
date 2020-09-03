<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\ProUser;
use App\Entity\User;
use App\Form\AdminProUserType;
use App\Form\AdminUserType;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * Permet d'afficher le profil public d'un pro avec ces commentaires    
     * 
     * @Route("/user-pro/{slug}", name="proUser_show")
     * 
     * @param ProUser $proUser
     * @param Request $request
     * 
     * @return Response
     */
    public function index(ProUser $proUser, Request $request, EntityManagerInterface $manager)
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setAuthor($this->getUser())
                    ->setProUser($proUser);

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre avis a bien été pris en compte."
            );
        }

        return $this->render('user/index.html.twig', [
            'proUser' => $proUser,
            'form'    => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition des utilisateurs 
     * sur la page d'administration
     *
     * @Route("/admin/users/{id}/edit", name="admin_user_edit")
     * 
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function editUser(Request $request, EntityManagerInterface $manager, User $user)
    {
        $form = $this->createForm(AdminUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "La modification du commentaire n° {$user->getId()} a bien été enregistrée."
            );
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
            ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition des professionnels 
     * sur la page d'administration
     *
     * @Route("/admin/prousers/{id}/edit", name="admin_proUser_edit")
     * 
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function editProUser(Request $request, EntityManagerInterface $manager, ProUser $proUser)
    {
        $form = $this->createForm(AdminProUserType::class, $proUser);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($proUser);
            $manager->flush();

            $this->addFlash(
                'success',
                "La modification du profil n° {$proUser->getId()} a bien été enregistrée."
            );
        }

        return $this->render('admin/proUser/edit.html.twig', [
            'proUser' => $proUser,
            'form' => $form->createView()
            ]);
    }

    /**
     * Permet de supprimer un profil utilisateur
     * 
     * @Route("/admin/users/{id}/delete", name="admin_user_delete")
     *
     * @param User $user
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function deleteUser(User $user, EntityManagerInterface $manager)
    {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le profil {$user->getFullName()} a bien été supprimé."
        );

        return $this->redirectToRoute('admin_users_index');
    }

    /**
     * Permet de supprimer un profil professionnel
     * 
     * @Route("/admin/prousers/{id}/delete", name="admin_prouser_delete")
     *
     * @param ProUser $user
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function deleteProUser(ProUser $user, EntityManagerInterface $manager)
    {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le profil {$user->getFullName()} a bien été supprimé."
        );

        return $this->redirectToRoute('admin_pro_index');
    }
}
