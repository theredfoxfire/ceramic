<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Buimage;
use AppBundle\Form\BuimageType;

/**
 * Buimage controller.
 *
 */
class BuimageController extends Controller
{
    /**
     * Lists all Buimage entities.
     *
     */
     public function indexAction(Request $request)
     {
         $em = $this->getDoctrine()->getManager();
         $dql   = "SELECT a FROM AppBundle:Buimage a";
         $query = $em->createQuery($dql);

         $paginator  = $this->get('knp_paginator');
         $pagination = $paginator->paginate(
             $query, /* query NOT result */
             $request->query->getInt('page', 1)/*page number*/,
             10/*limit per page*/
         );

         $buimage = $em->getRepository('AppBundle:Buimage')->findAll();
         $deleteForms = array();

         foreach ($buimage as $entity) {
             $deleteForms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
         }

         return $this->render('buimage/index.html.twig', array(
             'pagination' => $pagination,
             'deleteForms' => $deleteForms,
         ));
     }

    /**
     * Creates a new Buimage entity.
     *
     */
     public function newAction(Request $request)
     {
         $buimage = new Buimage();
         $form = $this->createForm(new BuimageType(), $buimage);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $file = $buimage->getLargeImage();
             $fileName = md5(uniqid()).'.'.$file->guessExtension();
             $file->move(
                 $this->container->getParameter('buimage_directory'),
                 $fileName
             );
             $buimage->setCreatedAt(new \DateTime());
             $buimage->setLargeImage($fileName);

             $em = $this->getDoctrine()->getManager();
             $em->persist($buimage);
             $em->flush();

             return $this->redirect($this->generateUrl('buimage_show', array('id' => $buimage->getId())));
         }

         return $this->render('buimage/new.html.twig', array(
             'buimage' => $buimage,
             'form' => $form->createView(),
         ));
     }

    /**
     * Finds and displays a Buimage entity.
     *
     */
    public function showAction(Buimage $buimage)
    {
        $deleteForm = $this->createDeleteForm($buimage);

        return $this->render('buimage/show.html.twig', array(
            'buimage' => $buimage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Buimage entity.
     *
     */
     public function editAction(Request $request, Buimage $buimage)
     {
         $deleteForm = $this->createDeleteForm( $buimage);
         $editForm = $this->createForm(new BuimageType(),  $buimage);
         $oldFile =  $buimage->getLargeImage();

         $editForm->handleRequest($request);

         if ($editForm->isSubmitted() && $editForm->isValid()) {
             $em = $this->getDoctrine()->getManager();
             if (file_exists($this->container->getParameter('buimage_directory').'/'.$oldFile)) {
                 unlink($this->container->getParameter('buimage_directory').'/'.$oldFile);
             }
             $file =  $buimage->getLargeImage();
             $fileName = md5(uniqid()).'.'.$file->guessExtension();
             $file->move(
                 $this->container->getParameter('buimage_directory'),
                 $fileName
             );
             $buimage->setLargeImage($fileName);
             $em->persist( $buimage);
             $em->flush();

             return $this->redirect($this->generateUrl('buimage_edit', array('id' =>  $buimage->getId())));
         }

         return $this->render('buimage/edit.html.twig', array(
             'buimage' => $buimage,
             'edit_form' => $editForm->createView(),
             'delete_form' => $deleteForm->createView(),
         ));
     }

    /**
     * Deletes a Buimage entity.
     *
     */
     public function deleteAction(Request $request, Buimage $buimage)
     {
         $form = $this->createDeleteForm($buimage);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $em = $this->getDoctrine()->getManager();
             if (file_exists($this->container->getParameter('buimage_directory').'/'.$buimage->getLargeImage())) {
                 unlink($this->container->getParameter('buimage_directory').'/'.$buimage->getLargeImage());
             }
             $em->remove($buimage);
             $em->flush();
         }

         return $this->redirect($this->generateUrl('buimage_index'));
     }

    /**
     * Creates a form to delete a Buimage entity.
     *
     * @param Buimage $buimage The Buimage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Buimage $buimage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('buimage_delete', array('id' => $buimage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
