<?php

namespace App\Controller\Front;

use App\Entity\Group;
use App\Form\GroupType;
use App\Repository\GroupRepository;
use App\Repository\PostRepository;
use App\Service\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/group")
 */
class GroupController extends AbstractController
{
    /**
     * @Route("/", name="group_index", methods={"GET"})
     */
    public function index(GroupRepository $groupRepository): Response
    {
        return $this->render('Front/group/index.html.twig', [
            'groups' => $groupRepository->findAll(),
        ]);
    }

    /**
     * @Route("/me", name="group_me", methods={"GET"})
     */
    public function indexOwner(GroupRepository $groupRepository): Response
    {
        //dd( $this->getUser()->getGroups() );
        return $this->render('Front/group/index.html.twig', [
            'groups' => $this->getUser()->getGroups(),//$groupRepository->findGroupByOwner( $this->getUser()->getId() ),
            'groupsOwn' => $groupRepository->findBy(['owner' => $this->getUser()]),
        ]);
    }

    /**
     * @Route("/leave/{id}", name="group_leave", methods={"GET"})
     */
    public function leave(Group $group , NotificationService $notificationService ): Response
    {
        $group->removeUser($this->getUser());

        $owner = $group->getOwner();
        $user = $this->getUser();

        $notificationService->setNotification( $user->getId(), $owner->getId(),
            $user->getFirstname() . ' has left the group ' . $group->getName(). ' .', $group->getId()
        );

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($group);
        $entityManager->flush();
        return $this->redirectToRoute('group_me');
    }

    /**
     * @Route("/new", name="group_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $group = new Group();
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $group->setOwner($this->getUser());
            //$group->setPlace(3);
            $entityManager->persist($group);
            $entityManager->flush();

            return $this->redirectToRoute('group_index');
        }

        return $this->render('Front/group/new.html.twig', [
            'group' => $group,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show", name="group_show", methods={"GET"})
     */
    public function show( PostRepository $postRepository, Group $group): Response
    {
        $post = $postRepository->findByOrganization( $group->getId() );
        return $this->render('Front/group/show.html.twig', [
            'group' => $group,
            'post' => $post
        ]);
    }

    /**
     * @Route("/{id}/edit", name="group_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Group $group, PostRepository $postRepository, GroupRepository $groupRepository): Response
    {
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('group_me');
        }

        $post = $postRepository->findByOrganization( $group->getId() );
        
        return $this->render('Front/group/edit.html.twig', [
            'group' => $group,
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="group_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Group $group, GroupRepository $groupRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$group->getId(), $request->request->get('_token'))) {
            $groupRepository->deletePosts($group);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($group);
            $entityManager->flush();
        }

        return $this->redirectToRoute('group_me');
    }
}
