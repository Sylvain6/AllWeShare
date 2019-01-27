<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailSending extends AbstractController
{
    public function sendEmailRegister($message, $email, $subject, $view, $params, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message($message))
            ->setFrom('allwesharethebest@gmail.com')
            ->setSubject($subject)
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    $view,
                    ['name' => $params]
                ),
                'text/html'
            );

        $mailer->send($message);
    }
}