<?php

namespace App\Controller;

use App\Service\Stats;
use App\Entity\Comment;
use App\Repository\ProUserRepository;
use App\Service\Pagination;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProUserDashboardController extends AbstractController
{
    /**
     * @Route("/pro/dashboard/{page}", name="pro_user_dashboard", requirements={"page" : "\d+"})
     */
    public function index(Stats $stats, Pagination $pagination, $page = 1)
    {
        $pagination->setEntityClass(Comment::class)
                   ->setLimit(10)
                   ->setCurrentPage($page)
        ;

        $pagination->getData();

        $allStats       = $stats->getStats();
        return $this->render('proUser/dashboard/index.html.twig', [
            'stats'     => $allStats,
            'pagination' =>  $pagination
        ]);
    }
}
