<?php

namespace App\Controller\Front;

use App\Entity\Comment;
use App\Entity\Group;
use App\Entity\Post;
use App\Form\CommentType;
use App\Service\NotificationService;
use App\Service\PaginationService;
use App\Form\PostType;
use App\Repository\CommentRepository;
use App\Repository\GroupRepository;
use App\Repository\PostRepository;
use PHPUnit\Runner\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_index", methods={"POST", "GET"} )
     */
    public function new(Request $request, PostRepository $postRepository, GroupRepository $groupRepository, PaginationService $paginationService): Response
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $post->setAuthor($user);
            $post->getOrganization()->setOwner($this->getUser());


            /*
             * Analyse du texte afin de detecter le type du compte
             */
            $res = self::analyzeContent(strtolower($post->getTitle()));
            //throw new \Exception( $res );
            if ($res !== 'undefined') {
                $post->setTypePost($res);
            } else {
                $res = self::analyzeContent($post->getDescription());
                $post->setTypePost($res);
            }


            $entityManager = $this->getDoctrine()->getManager();
            //throw new \Exception( json_encode( $this->getUser() ) );
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post_index');
        }

        $page = $request->get("page");
        if( empty( $page) ){
            $page = 1;
        }
        $entityManager = $this->getDoctrine()->getManager();

        $posts = $paginationService->finWithPagination( $page, 4,
            $entityManager->getRepository(Post::class ),
            null, 'p', 'p.createdAt', 'DESC' );
        //throw new \Exception( $posts->count() );
        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($posts) / 4),
            'nomRoute' => 'post_index',
            'paramsRoute' => array()
        );

        return $this->render('Front/post/index.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
            'posts' => $posts,
            'pagination' => $pagination,
            'groups' => $groupRepository->findBy(['owner' => $this->getUser()]),
        ]);
    }

    /**
     * @Route("/post/{id}", name="post_show", methods={"GET", "POST"})
     */
    public function show(Request $request, Post $post, CommentRepository $commentRepository, NotificationService $notificationService, PaginationService $paginationService ): Response

    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setPost($post);

            $user = $this->getUser();
            $comment->setAuthor( $user );

            $notificationService->setNotification( $user->getId(), $post->getAuthor()->getId(),
                $user->getFirstname() . ' has commented your post.', $post->getId()
                );


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('post_show', array('id' => $post->getId()));
        }

        $page = $request->get("page");
        if( empty( $page) ){
            $page = 1;
        }

        $entityManager = $this->getDoctrine()->getManager();

        $comments = $paginationService->finWithPagination( $page, 4,
            $entityManager->getRepository(Comment::class ),
            'c.post = :post_id', 'c', 'c.createdAt', 'ASC', [ 0 =>'post_id', 1 => $post->getId() ] );

        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($comments) / 4),
            'nomRoute' => 'post_show',
            'paramsRoute' => array('id' => $post->getId())
        );

        return $this->render('Front/post/show.html.twig', [
            'post' => $post,
            'comment' => $comment,
            'pagination' => $pagination,
            'comments' => $comments,
            'form' => $form->createView(),
            ]);
    }

    /**
     * @Route("/post/{id}/edit", name="post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post ): Response
    {
        $this->denyAccessUnlessGranted('edit', $post);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            /*
            * Analyse du texte afin de detecter le type du compte
            */
            $res = self::analyzeContent( $post->getTitle() );

            if( $res !== 'undefined' ){
                $post->setTypePost( $res );
            }
            else{
                $res = self::analyzeContent( $post->getDescription() );
                $post->setTypePost( $res );
            }

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('post_index', ['id' => $post->getId()]);
        }

        //throw new \Exception( $post->getTypePost() );
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


    public function analyzeContent( $content ){

        $content_exploded = explode(' ', $content);
        $find = false;

        $types_posts = [
            "netflix",
            'adn',
            'spotify',
            'deezer',
            'wakanim',
            'anime digital network'
        ];

        foreach ( $content_exploded as $content_e ){
            if( in_array( $content_e, $types_posts ) ){
                $type = $content_e;
                $find = true;
                break;
            }
        }
        if( $find ){
            return $type;
        }
        else{
            return "undefined";
        }
    }
}
