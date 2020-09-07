<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CguController extends AbstractController
{
    /**
     * @Route("/conditions-generales-d-utilisation", name="cgu")
     */
    public function index()
    {
        return $this->render('cgu/index.html.twig', [
        ]);
    }
}
