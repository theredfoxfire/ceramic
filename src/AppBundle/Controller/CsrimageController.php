<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Csrimage;
use AppBundle\Form\CsrimageType;

/**
 * Csrimage controller.
 *
 */
class CsrimageController extends Controller
{
    /**
     * Lists all Csrimage entities.
     *
     */
     public function indexAction(Request $request)
     {
         $em = $this->getDoctrine()->getManager();
         $dql   = "SELECT a FROM AppBundle:Csrimage a";
         $query = $em->createQuery($dql);

         $paginator  = $this->get('knp_paginator');
         $pagination = $paginator->paginate(
             $query, /* query NOT result */
             $request->query->getInt('page', 1)/*page number*/,
             10/*limit per page*/
         );

         $csrimage = $em->getRepository('AppBundle:Csrimage')->findAll();
         $deleteForms = array();

         foreach ($csrimage as $entity) {
             $deleteForms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
         }

         return $this->render('csrimage/index.html.twig', array(
             'pagination' => $pagination,
             'deleteForms' => $deleteForms,
         ));
     }

    /**
     * Creates a new Csrimage entity.
     *
     */
     public function newAction(Request $request)
     {
         $csrimage = new Csrimage();
         $form = $this->createForm(new CsrimageType(), $csrimage);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $file = $csrimage->getLargeImage();
             $fileName = md5(uniqid()).'.'.$file->guessExtension();
             $file->move(
                 $this->container->getParameter('csrimage_directory'),
                 $fileName
             );
             $csrimage->setCreatedAt(new \DateTime());
             $csrimage->setLargeImage($fileName);

             $em = $this->getDoctrine()->getManager();
             $em->persist($csrimage);
             $em->flush();

             return $this->redirect($this->generateUrl('csrimage_show', array('id' => $csrimage->getId())));
         }

         return $this->render('csrimage/new.html.twig', array(
             'csrimage' => $csrimage,
             'form' => $form->createView(),
         ));
     }

    /**
     * Finds and displays a Csrimage entity.
     *
     */
    public function showAction(Csrimage $csrimage)
    {
        $deleteForm = $this->createDeleteForm($csrimage);

        return $this->render('csrimage/show.html.twig', array(
            'csrimage' => $csrimage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Csrimage entity.
     *
     */
     public function editAction(Request $request, Csrimage $csrimage)
     {
         $deleteForm = $this->createDeleteForm( $csrimage);
         $editForm = $this->createForm(new CsrimageType(),  $csrimage);
         $oldFile =  $csrimage->getLargeImage();

         $editForm->handleRequest($request);

         if ($editForm->isSubmitted() && $editForm->isValid()) {
             $em = $this->getDoctrine()->getManager();
             if (file_exists($this->container->getParameter('csrimage_directory').'/'.$oldFile)) {
                 unlink($this->container->getParameter('csrimage_directory').'/'.$oldFile);
             }
             $file =  $csrimage->getLargeImage();
             $fileName = md5(uniqid()).'.'.$file->guessExtension();
             $file->move(
                 $this->container->getParameter('csrimage_directory'),
                 $fileName
             );
             $csrimage->setLargeImage($fileName);
             $em->persist( $csrimage);
             $em->flush();

             return $this->redirect($this->generateUrl('csrimage_edit', array('id' =>  $csrimage->getId())));
         }

         return $this->render('csrimage/edit.html.twig', array(
             'csrimage' => $csrimage,
             'edit_form' => $editForm->createView(),
             'delete_form' => $deleteForm->createView(),
         ));
     }

    /**
     * Deletes a Csrimage entity.
     *
     */
     public function deleteAction(Request $request, Csrimage $csrimage)
     {
         $form = $this->createDeleteForm($csrimage);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $em = $this->getDoctrine()->getManager();
             if (file_exists($this->container->getParameter('csrimage_directory').'/'.$csrimage->getLargeImage())) {
                 unlink($this->container->getParameter('csrimage_directory').'/'.$csrimage->getLargeImage());
             }
             $em->remove($csrimage);
             $em->flush();
         }

         return $this->redirect($this->generateUrl('csrimage_index'));
     }

    /**
     * Creates a form to delete a Csrimage entity.
     *
     * @param Csrimage $csrimage The Csrimage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Csrimage $csrimage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('csrimage_delete', array('id' => $csrimage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
