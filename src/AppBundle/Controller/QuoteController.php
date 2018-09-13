<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Quote;
use AppBundle\Form\QuoteType;

/**
 * Quote controller.
 *
 */
class QuoteController extends Controller
{
    /**
     * Lists all Quote entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM AppBundle:Quote a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        $quote = $em->getRepository('AppBundle:Quote')->findAll();
        $deleteForms = array();

        foreach ($quote as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        }

        return $this->render('quote/index.html.twig', array(
            'pagination' => $pagination,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new Quote entity.
     *
     */
    public function newAction(Request $request)
    {
        $quote = new Quote();
        $form = $this->createForm(new QuoteType(), $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($quote);
            $em->flush();

            return $this->redirect($this->generateUrl('quote_index'));
        }

        return $this->render('quote/new.html.twig', array(
            'quote' => $quote,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Quote entity.
     *
     */
    public function showAction(Quote $quote)
    {
        $deleteForm = $this->createDeleteForm($quote);

        return $this->render('quote/show.html.twig', array(
            'quote' => $quote,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Quote entity.
     *
     */
    public function editAction(Request $request, Quote $quote)
    {
        $deleteForm = $this->createDeleteForm($quote);
        $editForm = $this->createForm(new QuoteType(), $quote);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($quote);
            $em->flush();

            return $this->redirect($this->generateUrl('quote_index'));
        }

        return $this->render('quote/edit.html.twig', array(
            'quote' => $quote,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Quote entity.
     *
     */
    public function deleteAction(Request $request, Quote $quote)
    {
        $form = $this->createDeleteForm($quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($quote);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('quote_index'));
    }

    /**
     * Creates a form to delete a Quote entity.
     *
     * @param Quote $quote The Quote entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Quote $quote)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('quote_delete', array('id' => $quote->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
