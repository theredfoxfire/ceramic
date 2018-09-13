<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Users;
use AppBundle\Form\UsersType;
use AppBundle\Form\EditUsersType;

/**
 * Users controller.
 *
 */
class UsersController extends Controller
{
    /**
     * Lists all Users entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM AppBundle:Users a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        $users = $em->getRepository('AppBundle:Users')->findAll();
        $deleteForms = array();

        foreach ($users as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        }

        return $this->render('users/index.html.twig', array(
            'pagination' => $pagination,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new Users entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = new Users();
        $form = $this->createForm(new UsersType(), $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $factory = $this->container->get('security.encoder_factory');
            $plain = $request->request->get('users');
            $encoder = $factory->getEncoder($user);
            $user->setIsActive(true);
            $encodedPassword = $encoder->encodePassword($plain['password'], $user->getSalt());
            $user->setPassword($encodedPassword);
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('users_index'));
        }

        return $this->render('users/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Users entity.
     *
     */
    public function showAction(Users $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('users/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Users entity.
     *
     */
    public function editAction(Request $request, Users $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $oldPass = $user->getPassword();
        $editForm = $this->createForm(new EditUsersType(), $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $factory = $this->container->get('security.encoder_factory');
            $plain = $request->request->get('edit_users');
            if (!empty($plain)) {
              $encoder = $factory->getEncoder($user);
              $user->setIsActive(true);
              $encodedPassword = $encoder->encodePassword($plain['passwordEdit'], $user->getSalt());
              $user->setPassword($encodedPassword);
            } else {
              $user->setPassword($oldPass);
            }

            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('users_index'));
        }

        return $this->render('users/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Users entity.
     *
     */
    public function deleteAction(Request $request, Users $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('users_index'));
    }

    /**
     * Creates a form to delete a Users entity.
     *
     * @param Users $user The Users entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Users $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('users_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
