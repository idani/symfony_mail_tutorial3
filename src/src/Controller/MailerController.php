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
use Twig\Environment;

class MailerController extends AbstractController
{
    /**
     * @Route("/mailer", name="mailer")
     */
    public function index(MailerInterface $mailer, Environment $twig)
    {

        mb_language("uni");
        mb_internal_encoding("UTF-8");

        $subject = mb_encode_mimeheader('Thanks for signing up! 登録してくれてありがとうございます！！');
        $subject = str_replace("\r\n", '', $subject);

        $headers = (new Headers())
            ->addMailboxListHeader('From', [new Address('hello@example.com', mb_encode_mimeheader('送信者名'))])
            ->addMailboxListHeader('To', [new Address('you@example.com', mb_encode_mimeheader('受信者名'))])
            ->addTextHeader('Subject', $subject)
        ;

        $twigEmailTemplate =<<<EOL
Welcome !
ようこそ ！

    これはTwigテンプレートを変数から読み込んでレンダリングしたメールです。

    You signed up as {{ username }} the following email:
    次のメールアドレスで{{ username }}としてサインアップしました。

    {{ email }}


    Click here to activate your account
    アカウントを有効にするにはここをクリックしてください

    http://www.example.com/xxxxxxxxxxx
    (this link is valid until {{ expiration_date|date('F jS') }})
    （このリンクは、{{ expiration_date|date('F jS') }}まで有効です。

EOL;

        $template = $twig->createTemplate($twigEmailTemplate);
        $body = $template->render([
            'expiration_date' => new \DateTime('+7 days'),
            'username' => 'foo',
            'email' => 'you@example.com',
        ]);
        $textContent = new TextPart($body, 'utf-8', 'plain', 'base64');
        $email = new Message($headers, $textContent);

        $mailer->send($email);

        return $this->render('mailer/index.html.twig', [
            'controller_name' => 'MailerController',
        ]);
    }
}
