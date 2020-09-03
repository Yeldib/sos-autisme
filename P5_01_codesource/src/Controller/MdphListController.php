<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MdphListController extends AbstractController
{
    /**
     * @Route("/mdph/list", name="mdph_list")
     */
    public function index()
    {
        return $this->render('mdph_list/index.html.twig', [
        
        ]);
    }
}
