<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\AdminCommentType;
use App\Repository\CommentRepository;
use App\Repository\ProUserRepository;
use App\Service\Pagination;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comments/{page}", name="admin_comments_index", requirements={"page" : "\d+"})
     */
    public function index(ProUserRepository $proUserRepo, CommentRepository $comment, Pagination $pagination, $page = 1)
    {
        $pagination->setEntityClass(Comment::class)
                   ->setLimit(5)
                   ->setCurrentPage($page);

        $pagination->getData();
        
        return $this->render('admin/comment/index.html.twig', [
            'proUsers'  => $proUserRepo->findAll(),
            'pagination' =>  $pagination
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition des commentaires
     *
     * @Route("/admin/comments/{id}/edit", name="admin_comment_edit")
     * 
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Request $request, EntityManagerInterface $manager, Comment $comment)
    {
        $form = $this->createForm(AdminCommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "La modification du commentaire n° {$comment->getId()} a bien été enregistrée."
            );
        }

        return $this->render('admin/comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView()
            ]);
    }

    /**
     * Permet de supprimer un commentaire
     * 
     * @Route("/admin/comments/{id}/delete", name="admin_comment_delete")
     *
     * @param Comment $comment
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Comment $comment, EntityManagerInterface $manager)
    {
        $manager->remove($comment);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le commentaire {$comment->getAuthor()->getFullName()} a bien été supprimé."
        );

        return $this->redirectToRoute('admin_comments_index');
    }
}
