<?php

namespace App\Controller;

use App\Service\Email;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * Traite et affiche le formulaire de contact
     * 
     * @Route("/contact", name="contact_index")
     */
    public function index(Request $request, Email $email)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $email->sendEmail($contact);
            
            $this->addFlash('success', "Votre email a bien été envoyé");
            return $this->redirectToRoute('homepage');  
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
