<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\ProUser;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/pro-user/{slug}", name="proUser_show")
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
}
