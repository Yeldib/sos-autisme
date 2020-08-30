<?php

namespace App\Controller;

use App\Service\Stats;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(Stats $stats)
    {
        $allStats       = $stats->getStats();
        $bestProUsers   = $stats->getProUsersStats('DESC');
        $worstProUsers  = $stats->getProUsersStats('ASC');
        
        return $this->render('admin/dashboard/index.html.twig', [
            'stats'         => $allStats,
            'bestProUsers'  => $bestProUsers,
            'worstProUsers' => $worstProUsers
        ]);
    }
}
