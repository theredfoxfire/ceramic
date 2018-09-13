<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Slide;
use AppBundle\Form\SlideType;

/**
 * Slide controller.
 *
 */
class SlideController extends Controller
{
    /**
     * Lists all Slide entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM AppBundle:Slide a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
             $query, /* query NOT result */
             $request->query->getInt('page', 1)/*page number*/,
             10/*limit per page*/
         );

        $slide = $em->getRepository('AppBundle:Slide')->findAll();
        $deleteForms = array();

        foreach ($slide as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        }

        return $this->render('slide/index.html.twig', array(
             'pagination' => $pagination,
             'deleteForms' => $deleteForms,
         ));
    }

    /**
     * Creates a new Slide entity.
     *
     */
    public function newAction(Request $request)
    {
        $slide = new Slide();
        $form = $this->createForm(new SlideType(), $slide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $slide->getLargeImage();
            if (!empty($file)) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                 $this->container->getParameter('slide_directory'),
                 $fileName
             );
            } else {
                $fileName = 'media-img.png';
            }
            $slide->setCreatedAt(new \DateTime());
            $slide->setLargeImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($slide);
            $em->flush();

            return $this->redirect($this->generateUrl('slide_show', array('id' => $slide->getId())));
        }

        return $this->render('slide/new.html.twig', array(
             'slide' => $slide,
             'form' => $form->createView(),
         ));
    }

    /**
     * Finds and displays a Slide entity.
     *
     */
    public function showAction(Slide $slide)
    {
        $deleteForm = $this->createDeleteForm($slide);

        return $this->render('slide/show.html.twig', array(
            'slide' => $slide,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Slide entity.
     *
     */
    public function editAction(Request $request, Slide $slide)
    {
        $deleteForm = $this->createDeleteForm($slide);
        $editForm = $this->createForm(new SlideType(), $slide);
        $oldFile =  $slide->getLargeImage();

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if (file_exists($this->container->getParameter('slide_directory').'/'.$oldFile)) {
                unlink($this->container->getParameter('slide_directory').'/'.$oldFile);
            }
            $file =  $slide->getLargeImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                 $this->container->getParameter('slide_directory'),
                 $fileName
             );
            $slide->setLargeImage($fileName);
            $em->persist($slide);
            $em->flush();

            return $this->redirect($this->generateUrl('slide_edit', array('id' =>  $slide->getId())));
        }

        return $this->render('slide/edit.html.twig', array(
             'slide' => $slide,
             'edit_form' => $editForm->createView(),
             'delete_form' => $deleteForm->createView(),
         ));
    }

    /**
     * Deletes a Slide entity.
     *
     */
    public function deleteAction(Request $request, Slide $slide)
    {
        $form = $this->createDeleteForm($slide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if (file_exists($this->container->getParameter('slide_directory').'/'.$slide->getLargeImage())) {
                unlink($this->container->getParameter('slide_directory').'/'.$slide->getLargeImage());
            }
            $em->remove($slide);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('slide_index'));
    }

    /**
     * Creates a form to delete a Slide entity.
     *
     * @param Slide $slide The Slide entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Slide $slide)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('slide_delete', array('id' => $slide->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
