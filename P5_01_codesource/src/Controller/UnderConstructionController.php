<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UnderConstructionController extends AbstractController
{
    /**
     * @Route("/", name="under_construction")
     */
    public function index()
    {
        return $this->render('under_construction/index.html.twig', [
        ]);
    }
}
