<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


use App\Form\UserType;
use App\Entity\User;
use App\Form\ChangePassword;
use App\Repository\UserRepository;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use App\Service\MailSending;
use App\Service\GenerateToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\Config\Definition\Exception\Exception;


/**
 * Class UserController
 * @package App\Controller
 * @Route(name="app_front_security_")
 */

class SecurityController extends Controller
{
    /**
    * @Route("/login", name="login")
    */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('Front/security/login.html.twig', [
        'last_username' => $lastUsername,
        'error' => $error
        ]);
    }




    /**
     * @Route("/logout", name="logout")
     * @throws \Exception
     */

    public function logout(): void
    {
        throw new Exception('This should never be reached!');
    }
    /**
     * @Route("/register", name="registration")
     *
     */
    public function registerAction( Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer, MailSending $mailSending, GenerateToken $token)
    {
        if ($this->getUser() instanceof User) {
            return $this->redirectToRoute('app_front_default_home');
        }
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setIsActive( false );

            $generated = $token->generateToken();
            $user->setToken( $generated );

            $user->setRoles(['ROLE_USER']);

            $options_mail = array(
                'name' =>  $user->getFirstname(),
                'token' => $_SERVER['HTTP_HOST'].'/activate/'.$user->getToken()
            );

            $mailSending->sendEmail('Hello New Sharer',
                $user->getEmail(),
                'Inscription AllWeShare',
                'emails/registration.html.twig',
                $options_mail,
                $mailer);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'info',
                'A confirmation email was sent, please follow the instructions to complete your registration.'
            );

            return $this->redirectToRoute('app_front_security_login');
        }
        return $this->render(
            'Front/security/register.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/activate/{token}", name="activate_account", methods={"GET"})
     *
     */
    public function activateAccount( Request $request, User $user , $token ){

        if( !empty( $user->getId() ) && $user->getToken() == $token && $user->getIsActive() == false ){
            $user->setIsActive( true );
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Your registration is complete ! You can log in now.'
            );

            return $this->redirectToRoute('app_front_security_login');
        }else{
            $this->addFlash(
                'danger',
                'Your token is invalid, please click here to send a new token to activate your account.'
            );

            return $this->redirectToRoute('app_front_security_login');
        }
    }

    /**
     * @Route("/forgotPassword" , name="forgot_password", methods={"GET", "POST"})
     */

    public function forgottenPassword( Request $request, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer, MailSending $mailSending, UserRepository $userRepository ){

        $user = new User();

        $formPassword = $this->createForm(ChangePassword::class, $user );
        $formPassword->handleRequest( $request );

        if( $formPassword->isSubmitted() && $formPassword->isValid() ){
            //var_dump( $users ); die;
        }

        return $this->render('Front/security/forgotPassword.html.twig', [
            'user' => $user,
            'formPwd' => $formPassword->createView(),
        ]);
    }


}