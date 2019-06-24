<?php

namespace App\Controller\Back;

use App\Entity\ProfilePicture;
use App\Entity\User;
use App\Form\ProfilPictureType;
use App\Form\UserAccountType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\GenerateToken;
use App\Service\MailSending;
use App\Service\UploadFilesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController
 * @package App\Controller\Back
 * @Route("/user", name="admin")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="_user_index", methods={"GET"})
     */
    public function user_index(UserRepository $userRepository): Response
    {
        return $this->render('Back/user/index.html.twig', [
            'users' => $userRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}", name="_user_show", methods={"GET", "POST"})
     */
    public function user_show( Request $request, UploadFilesService $uploadFilesService, User $user ): Response
    {

        $pic = new ProfilePicture();


        $form = $this->createForm(UserAccountType::class, $user);
        $form->handleRequest($request);
        $form_picture = $this->createForm( ProfilPictureType::class, $pic);
        $form_picture->handleRequest($request);

        if( $form_picture->isSubmitted() && $form_picture->isValid() ){

            $file = $pic->getPicture();
            $fileName = $uploadFilesService->upload($file);

            $pic->setPicture($fileName);
            $user->setPicture( $pic );

            $this->getDoctrine()->getManager()->flush();
        }

        if ($form->isSubmitted() && $form->isValid() ) {

            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('Back/user/show.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'formPic' => $form_picture->createView(),
        ]);

    }

    /**
     * @Route("/edit/{id}", name="_user_edit", methods={"GET","POST"})
     */
    public function user_edit(Request $request, User $user, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user_index', ['id' => $user->getId()]);
        }

        return $this->render('Back/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="_user_delete", methods={"DELETE"})
     */
    public function user_delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_user_index');
    }

    /**
     * @Route("/new", name="_user_new", methods={"GET","POST"})
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

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('Back/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

}
