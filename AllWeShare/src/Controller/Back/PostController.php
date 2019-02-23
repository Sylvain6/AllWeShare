<?php

namespace App\Controller\Back;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PostController
 * @package App\Controller\Back
 * @Route("/post", name="admin")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="_post_index", methods={"GET"})
     */
    public function post_index(PostRepository $postRepository): Response
    {
        return $this->render('Back/post/index_owner.html.twig', ['posts' => $postRepository->findAll()]);
    }
    /**
     * @Route("/{id}", name="_post_show", methods={"GET"})

     */
    public function post_show(Post $post): Response
    {
        return $this->render('Back/post/show.html.twig', ['post' => $post]);
    }

    /**
     * @Route("/edit/{id}", name="_post_edit", methods={"GET","POST"})
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
     * @Route("/{id}", name="_post_delete", methods={"DELETE"})
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

}
