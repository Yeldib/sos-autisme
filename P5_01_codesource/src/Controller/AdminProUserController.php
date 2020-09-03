<?php

namespace App\Controller;

use App\Entity\ProUser;
use App\Repository\ProUserRepository;
use App\Service\Pagination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminProUserController extends AbstractController
{
    /**
     * @Route("/admin/users-pro", name="admin_pro_index")
     */
    public function index(ProUserRepository $proRepo, Pagination $pagination, $page = 1)
    {

        $pagination->setEntityClass(ProUser::class)
                   ->setCurrentPage($page)
                   ->setLimit(30)
                ;

        return $this->render('admin/proUser/index.html.twig', [
            'pagination' => $pagination,
            'proUsers' => $proRepo->findAll()
        ]);
    }
}
