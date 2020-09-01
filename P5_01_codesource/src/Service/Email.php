<?php 

namespace App\Service;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email as MimeEmail;
use Twig\Environment;

class Email extends AbstractController {

    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(MailerInterface $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function sendEmail(Contact $contact)
    {
        $message = (new MimeEmail())
            ->subject('Message de ' . $contact->getLastName() . ' ' . $contact->getFirstName() . ' (formulaire de contact sos-autsime)')
            ->from('noreply@sos-autisme.fr')
            ->to('eldibaliya@gmail.com')
            ->replyTo($contact->getEmail())
            ->html($this->renderer->render('emails/contact.html.twig', [
                'contact' => $contact
            ]), 'text/html')
        ;  
        $this->mailer->send($message);
    }
}