<?php 

namespace App\Controller;

use App\Entity\ProUser;
use App\Form\SearchUserType;
use App\Entity\SearchProUser;
use App\Form\SearchProUserType;
use App\Repository\ProUserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController  {

    /**
     * Affiche la page d'accueil
     *
     * @Route("/homepage", name="homepage")
     * 
     * @return Response
     */
    public function home(Request $request)
    {
        $search = new SearchProUser();
        $form = $this->createForm(SearchProUserType::class, $search);
        $form->handleRequest($request);

        $users = [];
        if($form->isSubmitted() && $form->isValid()) {
            //on récupère le métier et le departement selectionné dans le formulaire
            $jobCategory = $search->getJobCategory();   
            $department = $search->getDepartment();   
            if ($jobCategory!="" && $department!="") {
                $users= $this->getDoctrine()
                             ->getRepository(ProUser::class)
                             ->findBy(['jobCategory' => $jobCategory , 'department' => $department] );
            }
            if(!$users) {
                 $this->addFlash(
                    'danger',
                    "Aucun résultat pour cette recherche"
                );
            }  
            }

             return  $this->render('home.html.twig',[
                'form' =>$form->createView(),
                'users' => $users
                ]
            ); 
    }

}
