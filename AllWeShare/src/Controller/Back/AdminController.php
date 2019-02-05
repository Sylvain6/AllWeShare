<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Entity\Post;
use App\Form\UserType;
use App\Form\PostType;
use App\Repository\UserRepository;
use App\Repository\PostRepository;
use Egulias\EmailValidator\Exception\ExpectingDomainLiteralClose;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AdminController
 * @package App\Controller\Back
 * @Route(name="admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="_index", methods={"GET"})
     */
    public function index(Request $request, PostRepository $postRepository): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $post->setAuthor($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('Front/post/index.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
            'posts' => $postRepository->findAll(),
        ]);
    }

    /**
     * @Route("/users", name="_user_index", methods={"GET"})
     */
    public function user_index(UserRepository $userRepository): Response
    {
        return $this->render('Back/user/index.html.twig', ['users' => $userRepository->findAll()]);
    }

    /**
     * @Route("/posts", name="_post_index", methods={"GET"})
     */
    public function post_index(PostRepository $postRepository): Response
    {
        return $this->render('Back/post/index.html.twig', ['posts' => $postRepository->findAll()]);
    }


    /**
     * @Route("/user/{id}", name="_user_show", methods={"GET"})
     */
    public function user_show(User $user): Response
    {
        return $this->render('Back/user/show.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/post/{id}", name="_post_show", methods={"GET"})
     */
    public function post_show(Post $post): Response
    {
        return $this->render('Back/post/show.html.twig', ['post' => $post]);
    }

    /**
     * @Route("/user/edit/{id}", name="_user_edit", methods={"GET","POST"})
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
     * @Route("/post/edit/{id}", name="_post_edit", methods={"GET","POST"})
     */
    public function post_edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_post_index', ['id' => $post->getId()]);
        }

        return $this->render('Back/post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/{id}", name="_user_delete", methods={"DELETE"})
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
     * @Route("/post/{id}", name="_post_delete", methods={"DELETE"})
     */
    public function post_delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_post_index');
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
