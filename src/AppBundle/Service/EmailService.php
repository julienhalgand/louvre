<?php

namespace AppBundle\Service;

use \PHPMailer;
use \League;

use AppBundle\Entity\Bill;

class EmailService{
    private $mailer;
    private $twig;

    public function __construct(
        Array $email,
        \Twig_Environment $twig
    )
    {
        /****Mailer****/
        $this->mailer = new PHPMailer();
        $this->mailer->isSMTP();
        $this->mailer->SMTPDebug = 0;
        $this->mailer->Debugoutput = 'html';
        $this->mailer->Host = 'smtp.gmail.com';
        $this->mailer->Port = 587;
        $this->mailer->SMTPSecure = 'tls';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $email['send_by'];
        $this->mailer->Password = $email['password'];
        $this->mailer->setLanguage('fr');
        /*
        $this->mailer->oauthUserEmail = $email['send_by'];
        $this->mailer->oauthClientId = $email['client_id'];
        $this->mailer->oauthClientSecret = $email['client_secret'];
        $this->mailer->oauthRefreshToken = $email['refresh_token'];
        */
        $this->mailer->setFrom($email['send_by'], 'Louvre - Vos billets');
        /****Mailer****/
        $this->twig = $twig;
    }

    public function sendMail(Bill $bill){
        $this->mailer->addAddress($bill->getEmail());
        $this->mailer->Subject = 'Billetterie du Louvre - Vos billets pour le ' . $bill->getDateOfBooking();
        $this->mailer->Body= $this->renderBill($bill);
        $this->mailer->isHTML(true);
        $this->mailer->CharSet = 'UTF-8';
        if(!$this->mailer->send()) {
            return $this->mailer->ErrorInfo;
            exit();
        } else {
            return true;
            exit();
        }
    }
    public function renderBill(Bill $bill){

        $render = $this->twig->render('email/bill.html.twig', [
            'Bill'          => $bill
        ]);
       // die(dump($render));
        return $render;
    }

}