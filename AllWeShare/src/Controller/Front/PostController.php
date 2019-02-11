<?php

namespace App\Controller\Front;

use App\Entity\Comment;
use App\Entity\Post;
use App\EventListener\NotificationEvent;
use App\Form\CommentType;
use App\Form\PostType;
use App\Service\NotificationService;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_index", methods={"GET","POST"})
     */
    public function new(Request $request, PostRepository $postRepository): Response
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
     * @Route("/post/{id}", name="post_show", methods={"GET", "POST"})
     */
    public function show(Request $request, Post $post, CommentRepository $commentRepository, NotificationService $notif ): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setPost($post);
            $user = $this->getUser();
            $comment->setAuthor($user);

            $notification = $notif->setNotifications( $user->getId(), $post->getAuthor()->getId() , $user->getFirstname() . " as commented your post." );



            $notifEvent = new NotificationEvent( $notification );

            $notif = $this->get('event_dispatcher')->dispatch('notification.add', $notifEvent)->getNotification();


            //todo : setNotification
            // comment_author as id_sender
            // post_author as receiver
            // content to define : xxxx as commented your post
            //is_seen = false

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('post_show', array('id' => $post->getId()));
        }
        return $this->render('Front/post/show.html.twig', [
            'post' => $post,
            'comment' => $comment,
            'comments' => $commentRepository->findBy(['post' => $post], ['createdAt' => 'ASC']),
            'form' => $form->createView(),
            ]);
    }

    /**
     * @Route("/post/{id}/edit", name="post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post): Response
    {
        $this->denyAccessUnlessGranted('edit', $post);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_index', ['id' => $post->getId()]);
        }

        return $this->render('Front/post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/post/{id}", name="post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Post $post): Response
    {
        $this->denyAccessUnlessGranted('delete', $post);
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index');
    }
}
