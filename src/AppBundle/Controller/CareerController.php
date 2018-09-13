<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Career;
use AppBundle\Form\CareerType;

/**
 * Career controller.
 *
 */
class CareerController extends Controller
{
    /**
     * Lists all Career entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM AppBundle:Career a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        $career = $em->getRepository('AppBundle:Career')->findAll();
        $deleteForms = array();

        foreach ($career as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        }

        return $this->render('career/index.html.twig', array(
            'careers' => $pagination,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Render page after success submit
     *
     */
    public function sucessAction()
    {
        return $this->render('career/sucess.html.twig', array(
            'categories' => $this->get('app.services.getCategories')->getCategories(),
        ));
    }

    /**
     * Creates a new Career entity.
     *
     */
    public function newAction(Request $request)
    {
        $career = new Career();
        $form = $this->createForm(new CareerType(), $career);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($career);
            $em->flush();

            return $this->redirect($this->generateUrl('career_sucess'));
        }

        return $this->render('career/new.html.twig', array(
            'career' => $career,
            'form' => $form->createView(),
            'categories' => $this->get('app.services.getCategories')->getCategories(),
        ));
    }

    /**
     * Finds and displays a Career entity.
     *
     */
    public function showAction(Career $career)
    {
        $deleteForm = $this->createDeleteForm($career);

        return $this->render('career/show.html.twig', array(
            'career' => $career,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Career entity.
     *
     */
    public function editAction(Request $request, Career $career)
    {
        $deleteForm = $this->createDeleteForm($career);
        $editForm = $this->createForm(new CareerType(), $career);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($career);
            $em->flush();

            return $this->redirect($this->generateUrl('career_edit', array('id' => $career->getId())));
        }

        return $this->render('career/edit.html.twig', array(
            'career' => $career,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Career entity.
     *
     */
    public function deleteAction(Request $request, Career $career)
    {
        $form = $this->createDeleteForm($career);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($career);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('career_index'));
    }

    /**
     * Creates a form to delete a Career entity.
     *
     * @param Career $career The Career entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Career $career)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('career_delete', array('id' => $career->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
