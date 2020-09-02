<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UsefulLinkController extends AbstractController
{
    /**
     * @Route("/liens-utiles", name="useful_link")
     */
    public function index()
    {
        return $this->render('useful_link/index.html.twig', [
            
        ]);
    }
}
