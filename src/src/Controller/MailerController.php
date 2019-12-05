<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Header\Headers;
use Symfony\Component\Mime\Message;
use Symfony\Component\Mime\Part\TextPart;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    /**
     * @Route("/mailer", name="mailer")
     */
    public function index(MailerInterface $mailer)
    {

        $email = (new TemplatedEmail())
            ->from('fabien@example.com')
            ->to(new Address('ryan@example.com'))
            ->subject('Thanks for signing up!')

            // path of the Twig template to render
            ->htmlTemplate('emails/signup.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'username' => 'foo',
            ])
            ->textTemplate('emails/signup.txt.twig')
        ;

        $mailer->send($email);

        return $this->render('mailer/index.html.twig', [
            'controller_name' => 'MailerController',
        ]);
    }
}
