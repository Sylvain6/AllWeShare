<?php

namespace App\Controller\Front;

use App\Entity\Post;
use App\Entity\Request as RequestObject;
use App\Form\RequestType;
use App\Repository\RequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/request")
 */
class RequestController extends AbstractController
{
    /**
     * @Route("/", name="request_index", methods={"GET"})
     */
    public function index(RequestRepository $requestRepository): Response
    {
        return $this->render('Front/request/index_owner.html.twig', [
            'requests' => $requestRepository->findAll(),
        ]);
    }

    /**
     * @Route("/applicant", name="request_applicant", methods={"GET"})
     */
    public function showByApplicant(RequestRepository $requestRepository): Response
    {
        return $this->render('Front/request/index_applicant.html.twig', [
            'requests' => $requestRepository->findBy(['applicant' => $this->getUser()]),
        ]);
    }

    /**
     * @Route("/owner", name="request_owner", methods={"GET"})
     */
    public function showByOwner(RequestRepository $requestRepository): Response
    {
        return $this->render('Front/request/index_owner.html.twig', [
            'requests' => $requestRepository->findByOwner($this->getUser()),
        ]);
    }

    /**
     * @Route("/accept/{id}", name="request_accept", methods={"GET"})
     */
    public function accept(RequestObject $request): Response
    {
        $place = $request->getPost()->getOrganization()->getPlace();
        $applicant = $request->getApplicant();
        if ($place > 0){
            $request->setStatus('ACCEPTED');
            $request->getPost()->getOrganization()->addUser($applicant);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($request);
            $entityManager->flush();

            return $this->redirectToRoute('request_owner');
        }
        $request->setStatus('PENDING');
        return $this->redirectToRoute('request_owner');
    }

    /**
     * @Route("/reject/{id}", name="request_reject", methods={"GET"})
     */
    public function reject(RequestObject $request): Response
    {
        $request->setStatus('REJECTED');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($request);
        $entityManager->flush();

        return $this->redirectToRoute('request_owner');
    }

    /**
     * @Route("/new/{id}", name="request_new", methods={"GET","POST"})
     */
    public function new(Post $post): Response
    {
        if ($post->getOrganization()->getPlace() == 0){
            return $this->redirectToRoute('post_index');
        }
        $request = new RequestObject();
        $user = $this->getUser();
        $request->setStatus('PENDING');
        $request->setApplicant($user);
        $request->setPost($post);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($request);
        $entityManager->flush();

        return $this->redirectToRoute('request_applicant');

    }

    /**
     * @Route("/{id}", name="request_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RequestObject $requestObject): Response
    {
        if ($this->isCsrfTokenValid('delete'.$requestObject->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($requestObject);
            $entityManager->flush();
        }

        return $this->redirectToRoute('request_index');
    }
}
