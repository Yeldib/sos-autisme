<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Pagination;
use App\Repository\ProUserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/users/{page}", name="admin_users_index", requirements={"page" : "\d+"})
     */
    public function index(ProUserRepository $proUserRepo, Pagination $pagination, $page = 1)
    {
        $pagination->setEntityClass(User::class)
                   ->setCurrentPage($page)
                   ->setLimit(5);

        return $this->render('admin/user/index.html.twig', [
            'pagination' => $pagination,
            'proUsers'  => $proUserRepo->findAll()
        ]);
    }
}
