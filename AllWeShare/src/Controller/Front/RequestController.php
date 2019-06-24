<?php

namespace App\Controller\Front;

use App\Entity\Post;
use App\Entity\Request as RequestObject;
use App\Form\RequestType;
use App\Repository\RequestRepository;
use App\Service\NotificationService;
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
            'requests' => $requestRepository->findBy(['applicant' => $this->getUser(), 'status' => 'PENDING']),
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
    public function accept(RequestObject $request,  NotificationService $notificationService ): Response
    {
        $place = $request->getPost()->getOrganization()->getPlace();
        $applicant = $request->getApplicant();
        if ($place > 0){
            $request->setStatus('ACCEPTED');
            $user = $this->getUser();
            $request->getPost()->getOrganization()->addUser($applicant);

            $notificationService->setNotification( $user->getId(), $applicant->getId(),
                $user->getFirstname() . ' has approved your request to join the group.', $request->getPost()->getId()
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($request);
            $entityManager->flush();

            return $this->redirectToRoute('request_owner');
        }
        $this->addFlash(
            'info',
            'There is no more place in this group'
        );
        $request->setStatus('PENDING');
        return $this->redirectToRoute('request_owner');
    }

    /**
     * @Route("/reject/{id}", name="request_reject", methods={"GET"})
     */
    public function reject(RequestObject $request, NotificationService $notificationService ): Response
    {
        $request->setStatus('REJECTED');

        $user = $this->getUser();
        $applicant = $request->getApplicant();

        $notificationService->setNotification( $user->getId(), $applicant->getId(),
            $user->getFirstname() . ' has rejected your request to join the group.', $request->getPost()->getId()
        );

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($request);
        $entityManager->flush();

        return $this->redirectToRoute('request_owner');
    }

    /**
     * @Route("/new/{id}", name="request_new", methods={"GET","POST"})
     */
    public function new(Post $post, NotificationService $notificationService ): Response
    {
        if ($post->getOrganization()->getPlace() == 0){
            $this->addFlash('info', 'No more place in this group');
            return $this->redirectToRoute('post_index');
        }
        if ($post->getOrganization()->getOwner() == $this->getUser()){
            $this->addFlash('info', 'You can\'t request to your own post');
            return $this->redirectToRoute('post_index');
        }
        $request = new RequestObject();
        $user = $this->getUser();

        $notificationService->setNotification( $user->getId(), $post->getAuthor()->getId(),
            $user->getFirstname() . ' has made a request to join your group.', $post->getId()
        );

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
