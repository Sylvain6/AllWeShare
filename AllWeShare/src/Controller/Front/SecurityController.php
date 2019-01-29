<?php
namespace App\Controller\Front;
use App\Form\UserType;
use App\Entity\User;
use App\Service\MailSending;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
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
    public function login(AuthenticationUtils $helper): Response
    {
        return $this->render('Front/security/login.html.twig', [
            'error' => $helper->getLastAuthenticationError(),
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
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer, MailSending $mailSending)
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
            $user->setRoles(['ROLE_USER']);
            $mailSending->sendEmailRegister('Hello New Sharer',
                $user->getEmail(),
                'Inscription AllWeShare',
                'emails/registration.html.twig',
                $user->getFirstname(),
                $mailer);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_front_security_login');
        }
        return $this->render(
            'Front/security/register.html.twig', [
                'form' => $form->createView()
            ]
        );
    }
}