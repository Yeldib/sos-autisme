<?php

namespace App\Controller;

use App\Repository\ProUserRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/users", name="admin_users_index")
     */
    public function index(UserRepository $userRepo, ProUserRepository $proUserRepo)
    {
        return $this->render('admin/user/index.html.twig', [
            'users'     => $userRepo->findAll(),
            'proUsers'  => $proUserRepo->findAll()
        ]);
    }
}
