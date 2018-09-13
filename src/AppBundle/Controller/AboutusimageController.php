<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Aboutusimage;
use AppBundle\Form\AboutusimageType;

/**
 * Aboutusimage controller.
 *
 */
class AboutusimageController extends Controller
{
    /**
     * Lists all Aboutusimage entities.
     *
     */
     public function indexAction(Request $request)
     {
         $em = $this->getDoctrine()->getManager();
         $dql   = "SELECT a FROM AppBundle:Aboutusimage a";
         $query = $em->createQuery($dql);

         $paginator  = $this->get('knp_paginator');
         $pagination = $paginator->paginate(
             $query, /* query NOT result */
             $request->query->getInt('page', 1)/*page number*/,
             10/*limit per page*/
         );

         $aboutusimage = $em->getRepository('AppBundle:Aboutusimage')->findAll();
         $deleteForms = array();

         foreach ($aboutusimage as $entity) {
             $deleteForms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
         }

         return $this->render('aboutusimage/index.html.twig', array(
             'pagination' => $pagination,
             'deleteForms' => $deleteForms,
         ));
     }

    /**
     * Creates a new Aboutusimage entity.
     *
     */
     public function newAction(Request $request)
     {
         $aboutusimage = new Aboutusimage();
         $form = $this->createForm(new AboutusimageType(), $aboutusimage);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $file = $aboutusimage->getLargeImage();
             $fileName = md5(uniqid()).'.'.$file->guessExtension();
             $file->move(
                 $this->container->getParameter('aboutusimage_directory'),
                 $fileName
             );
             $aboutusimage->setCreatedAt(new \DateTime());
             $aboutusimage->setLargeImage($fileName);

             $em = $this->getDoctrine()->getManager();
             $em->persist($aboutusimage);
             $em->flush();

             return $this->redirect($this->generateUrl('aboutusimage_show', array('id' => $aboutusimage->getId())));
         }

         return $this->render('aboutusimage/new.html.twig', array(
             'aboutusimage' => $aboutusimage,
             'form' => $form->createView(),
         ));
     }

    /**
     * Finds and displays a Aboutusimage entity.
     *
     */
    public function showAction(Aboutusimage $aboutusimage)
    {
        $deleteForm = $this->createDeleteForm($aboutusimage);

        return $this->render('aboutusimage/show.html.twig', array(
            'aboutusimage' => $aboutusimage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Aboutusimage entity.
     *
     */
     public function editAction(Request $request, Aboutusimage $aboutusimage)
     {
         $deleteForm = $this->createDeleteForm( $aboutusimage);
         $editForm = $this->createForm(new AboutusimageType(),  $aboutusimage);
         $oldFile =  $aboutusimage->getLargeImage();

         $editForm->handleRequest($request);

         if ($editForm->isSubmitted() && $editForm->isValid()) {
             $em = $this->getDoctrine()->getManager();
             if (file_exists($this->container->getParameter('aboutusimage_directory').'/'.$oldFile)) {
                 unlink($this->container->getParameter('aboutusimage_directory').'/'.$oldFile);
             }
             $file =  $aboutusimage->getLargeImage();
             $fileName = md5(uniqid()).'.'.$file->guessExtension();
             $file->move(
                 $this->container->getParameter('aboutusimage_directory'),
                 $fileName
             );
             $aboutusimage->setLargeImage($fileName);
             $em->persist( $aboutusimage);
             $em->flush();

             return $this->redirect($this->generateUrl('aboutusimage_edit', array('id' =>  $aboutusimage->getId())));
         }

         return $this->render('aboutusimage/edit.html.twig', array(
             'aboutusimage' => $aboutusimage,
             'edit_form' => $editForm->createView(),
             'delete_form' => $deleteForm->createView(),
         ));
     }

    /**
     * Deletes a Aboutusimage entity.
     *
     */
     public function deleteAction(Request $request, Aboutusimage $aboutusimage)
     {
         $form = $this->createDeleteForm($aboutusimage);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $em = $this->getDoctrine()->getManager();
             if (file_exists($this->container->getParameter('aboutusimage_directory').'/'.$aboutusimage->getLargeImage())) {
                 unlink($this->container->getParameter('aboutusimage_directory').'/'.$aboutusimage->getLargeImage());
             }
             $em->remove($aboutusimage);
             $em->flush();
         }

         return $this->redirect($this->generateUrl('aboutusimage_index'));
     }

    /**
     * Creates a form to delete a Aboutusimage entity.
     *
     * @param Aboutusimage $aboutusimage The Aboutusimage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Aboutusimage $aboutusimage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aboutusimage_delete', array('id' => $aboutusimage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
