<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


use App\Form\UserType;
use App\Entity\User;
use App\Form\ChangePasswordType;
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

            $user->setRoles( '{"roles": "ROLE_USER" }' );

            $options_mail = array(
                'name' =>  $user->getFirstname(),
                'token' => 'http://' . $_SERVER['HTTP_HOST'].'/activate/'.$user->getToken()
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
     * @Route("/forgotPassword" , name="forgot_password")
     */

    public function forgottenPassword( Request $request, UserRepository $userRepository, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer, MailSending $mailSending , GenerateToken $token){

        $user = new User();

        $formPassword = $this->createForm(ChangePasswordType::class, $user );

        $formPassword->handleRequest($request);

        //dump( $formPassword ); die;

        if( $formPassword->isSubmitted() && $formPassword->isValid() ){

            $data = $formPassword->getData();
            $user_exist = $userRepository->findOneByEmail( $data->getEmail() );

            if( !empty( $user_exist ) ){
                $encoded = $encoder->encodePassword($user, $data->getPassword() );
                $user_exist->setToChangePassword( $encoded );

                $generated = $token->generateToken();
                $user_exist->setToken( $generated );

                $options_mail = array(
                    'name' =>  $user_exist->getFirstname(),
                    'token' => 'http://' . $_SERVER['HTTP_HOST'] .'/change_password/'.$user_exist->getToken()
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

                return $this->redirectToRoute('app_front_security_login');
            }
            else{
                #TODO: message d'erreur si le mail n'existe pas ?
            }
        }

        return $this->render('Front/security/forgotPassword.html.twig', [
            'formPwd' => $formPassword->createView(),
        ]);
    }


    /**
     * @Route("/change_password/{token}", name="change_password" )
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

            return $this->redirectToRoute('app_front_security_login');
        }else{
            $this->addFlash(
                'danger',
                'Your token is invalid, your password hasn\'t been changed'
            );

            return $this->redirectToRoute('app_front_security_login');
        }
    }


}