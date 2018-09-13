<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Logo;
use AppBundle\Form\LogoType;

/**
 * Logo controller.
 *
 */
class LogoController extends Controller
{
    /**
     * Lists all Logo entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM AppBundle:Logo a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
             $query, /* query NOT result */
             $request->query->getInt('page', 1)/*page number*/,
             10/*limit per page*/
         );

        $logo = $em->getRepository('AppBundle:Logo')->findAll();
        $deleteForms = array();

        foreach ($logo as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        }

        return $this->render('logo/index.html.twig', array(
             'pagination' => $pagination,
             'deleteForms' => $deleteForms,
         ));
    }

    /**
     * Creates a new Logo entity.
     *
     */
    public function newAction(Request $request)
    {
        $logo = new Logo();
        $form = $this->createForm(new LogoType(), $logo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $logo->getLargeImage();
            if (!empty($file)) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                   $this->container->getParameter('logo_directory'),
                   $fileName
               );
            } else {
                $fileName = 'media-img.png';
            }
            $logo->setCreatedAt(new \DateTime());
            $logo->setLargeImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($logo);
            $em->flush();

            return $this->redirect($this->generateUrl('logo_show', array('id' => $logo->getId())));
        }

        return $this->render('logo/new.html.twig', array(
             'logo' => $logo,
             'form' => $form->createView(),
         ));
    }

    /**
     * Finds and displays a Logo entity.
     *
     */
    public function showAction(Logo $logo)
    {
        $deleteForm = $this->createDeleteForm($logo);

        return $this->render('logo/show.html.twig', array(
            'logo' => $logo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Logo entity.
     *
     */
    public function editAction(Request $request, Logo $logo)
    {
        $deleteForm = $this->createDeleteForm($logo);
        $editForm = $this->createForm(new LogoType(), $logo);
        $oldFile =  $logo->getLargeImage();

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if (file_exists($this->container->getParameter('logo_directory').'/'.$oldFile)) {
                unlink($this->container->getParameter('logo_directory').'/'.$oldFile);
            }
            $file =  $logo->getLargeImage();
            if (!empty($file)) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                 $this->container->getParameter('logo_directory'),
                 $fileName
             );
                $logo->setLargeImage($fileName);
            } else {
                $logo->setLargeImage($oldFile);
            }
            $em->persist($logo);
            $em->flush();

            return $this->redirect($this->generateUrl('logo_edit', array('id' =>  $logo->getId())));
        }

        return $this->render('logo/edit.html.twig', array(
             'logo' => $logo,
             'edit_form' => $editForm->createView(),
             'delete_form' => $deleteForm->createView(),
         ));
    }

    /**
     * Deletes a Logo entity.
     *
     */
    public function deleteAction(Request $request, Logo $logo)
    {
        $form = $this->createDeleteForm($logo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if (file_exists($this->container->getParameter('logo_directory').'/'.$logo->getLargeImage())) {
                unlink($this->container->getParameter('logo_directory').'/'.$logo->getLargeImage());
            }
            $em->remove($logo);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('logo_index'));
    }

    /**
     * Creates a form to delete a Logo entity.
     *
     * @param Logo $logo The Logo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Logo $logo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('logo_delete', array('id' => $logo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
