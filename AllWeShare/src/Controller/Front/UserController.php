<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\UserType;
use App\Form\UserAccountType;
use App\Repository\UserRepository;
use App\Service\GenerateToken;
use Egulias\EmailValidator\Exception\ExpectingDomainLiteralClose;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/*
 * Uses for accountForm
 */
use Symfony\Component\Form\Extension\Core\Type\TextType;

use App\Service\MailSending;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('Front/user/index.html.twig', ['users' => $userRepository->findAll()]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('Front/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/account", name="user_account", methods={"GET", "POST"})
     */
    public function account( Request $request, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer, MailSending $mailSending , GenerateToken $token ): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserAccountType::class, $user);
        $form->handleRequest($request);

        $formPassword = $this->createForm(ChangePasswordType::class, $user );
        $formPassword->handleRequest( $request );

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_account');
        }

        if( $formPassword->isSubmitted() && $formPassword->isValid() ){
            //throw new Exception( json_encode(  $user->getPassword() ) );
            $encoded = $encoder->encodePassword($user, $user->getToChangePassword());
            //throw new Exception( json_encode( $encoded ) );
            $user->setToChangePassword($encoded);

            $generated = $token->generateToken();
            $user->setToken( $generated );

            $options_mail = array(
                'name' =>  $user->getFirstname(),
                'token' => 'http://'.$_SERVER['HTTP_HOST'] .'/user/change_password/'.$user->getToken()
            );
            $mailSending->sendEmail('Password Change',
                $user->getEmail(),
                'Change your password on AllWeShare',
                'emails/forgotPassword.html.twig',
                $options_mail,
                $mailer);

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'info',
                'An email as been sent to confirm you new password.'
            );

            return $this->redirectToRoute('user_account');
        }

        return $this->render('Front/user/account.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'formPwd' => $formPassword->createView(),
        ]);

    }

    /**
     * @Route("/change_password/{token}", name="user_change_pwd", methods={"GET", "POST"})
     */

    public function changePassword( Request $request, User $user , $token ){

        if( !empty( $user->getId() ) && $user->getToken() == $token && $user->getToChangePassword() != null ){
            $pwd = $user->getToChangePassword();
            $user->setPassword( $pwd );
            $user->setToChangePassword(null);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Your password has been changed.'
            );

            return $this->redirectToRoute('user_account');
        }else{
            $this->addFlash(
                'danger',
                'Your token is invalid, your password hasn\'t been changed'
            );

            return $this->redirectToRoute('user_account');
        }
    }
}
