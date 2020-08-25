<?php

namespace App\Controller;

use App\Entity\ProUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/pro-user/{slug}", name="proUser_show")
     */
    public function index(ProUser $proUser)
    {

        return $this->render('user/index.html.twig', [
            'proUser' => $proUser
        ]);
    }
}
