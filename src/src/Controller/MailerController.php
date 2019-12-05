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

        mb_language("uni") ;
        mb_internal_encoding("UTF-8") ;
        $subject = mb_encode_mimeheader('日本語のサブジェクトになります。長くなると文字化けするという話もありますので、長く書いてみます。これぐらい長いとどうかな？');
        $subject = str_replace("\r\n", '', $subject);

        $headers = (new Headers())
            ->addMailboxListHeader('From', [new Address('hello@example.com', mb_encode_mimeheader('送信者名'))])
            ->addMailboxListHeader('To', [new Address('you@example.com', mb_encode_mimeheader('受信者名'))])
            ->addTextHeader('Subject', $subject)

        ;

        $body = $this->render('emails/symfony.txt.twig');
        $textContent = new TextPart($body, 'utf-8', 'plain', 'base64');
        $email = new Message($headers, $textContent);

        $mailer->send($email);

        return $this->render('mailer/index.html.twig', [
            'controller_name' => 'MailerController',
        ]);
    }
}
