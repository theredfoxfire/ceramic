<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Overview;
use AppBundle\Form\OverviewType;

/**
 * Overview controller.
 *
 */
class OverviewController extends Controller
{
    /**
     * Lists all Overview entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM AppBundle:Overview a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
             $query, /* query NOT result */
             $request->query->getInt('page', 1)/*page number*/,
             10/*limit per page*/
         );

        $overview = $em->getRepository('AppBundle:Overview')->findAll();
        $deleteForms = array();

        foreach ($overview as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        }

        return $this->render('overview/index.html.twig', array(
             'pagination' => $pagination,
             'deleteForms' => $deleteForms,
         ));
    }

    /**
     * Creates a new Overview entity.
     *
     */
    public function newAction(Request $request)
    {
        $overview = new Overview();
        $form = $this->createForm(new OverviewType(), $overview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($overview);
            $em->flush();

            return $this->redirect($this->generateUrl('overview_show', array('id' => $overview->getId())));
        }

        return $this->render('overview/new.html.twig', array(
             'overview' => $overview,
             'form' => $form->createView(),
         ));
    }

    /**
     * Finds and displays a Overview entity.
     *
     */
    public function showAction(Overview $overview)
    {
        $deleteForm = $this->createDeleteForm($overview);

        return $this->render('overview/show.html.twig', array(
            'overview' => $overview,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Overview entity.
     *
     */
    public function editAction(Request $request, Overview $overview)
    {
        $deleteForm = $this->createDeleteForm($overview);
        $editForm = $this->createForm(new OverviewType(), $overview);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($overview);
            $em->flush();

            return $this->redirect($this->generateUrl('overview_index'));
        }

        return $this->render('overview/edit.html.twig', array(
             'overview' => $overview,
             'edit_form' => $editForm->createView(),
             'delete_form' => $deleteForm->createView(),
         ));
    }

    /**
     * Deletes a Overview entity.
     *
     */
    public function deleteAction(Request $request, Overview $overview)
    {
        $form = $this->createDeleteForm($overview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($overview);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('overview_index'));
    }

    /**
     * Creates a form to delete a Overview entity.
     *
     * @param Overview $overview The Overview entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Overview $overview)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('overview_delete', array('id' => $overview->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
