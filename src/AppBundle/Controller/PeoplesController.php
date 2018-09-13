<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Peoples;
use AppBundle\Form\PeoplesType;

/**
 * Peoples controller.
 *
 */
class PeoplesController extends Controller
{
    /**
     * Lists all Peoples entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM AppBundle:Peoples a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
             $query, /* query NOT result */
             $request->query->getInt('page', 1)/*page number*/,
             10/*limit per page*/
         );

        $peoples = $em->getRepository('AppBundle:Peoples')->findAll();
        $deleteForms = array();

        foreach ($peoples as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        }

        return $this->render('peoples/index.html.twig', array(
             'pagination' => $pagination,
             'deleteForms' => $deleteForms,
         ));
    }

    /**
     * Lists all Peoples entities.
     *
     */
    public function indexPublicAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM AppBundle:Peoples a where a.id != 1";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
             $query, /* query NOT result */
             $request->query->getInt('page', 1)/*page number*/,
             10/*limit per page*/
         );

        $peoples = $em->getRepository('AppBundle:Peoples')->findAll();
        $judit = $em->getRepository('AppBundle:Peoples')->findOneById(1);
        $numRow = $em->getRepository('AppBundle:Peoples')->getRows();

        return $this->render('peoples/indexPublic.html.twig', array(
             'pagination' => $pagination,
             'judit' => $judit,
             'numRow' => $numRow,
             'categories' => $this->get('app.services.getCategories')->getCategories(),
         ));
    }

    /**
     * Creates a new Peoples entity.
     *
     */
    public function newAction(Request $request)
    {
        $peoples = new Peoples();
        $form = $this->createForm(new PeoplesType(), $peoples);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $peoples->getLargeImage();
            if (!empty($file)) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                $this->container->getParameter('peoples_directory'),
                $fileName
            );
            } else {
                $fileName = 'media-img.png';
            }
            $peoples->setLargeImage($fileName);
            $em->persist($peoples);
            $em->flush();

            return $this->redirect($this->generateUrl('peoples_index'));
        }

        return $this->render('peoples/new.html.twig', array(
            'peoples' => $peoples,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Peoples entity.
     *
     */
    public function showAction(Peoples $peoples)
    {
        $deleteForm = $this->createDeleteForm($peoples);

        return $this->render('peoples/show.html.twig', array(
            'peoples' => $peoples,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a Peoples entity.
     *
     */
    public function showPublicAction(Peoples $peoples)
    {
        return $this->render('peoples/showPublic.html.twig', array(
            'peoples' => $peoples,
            'categories' => $this->get('app.services.getCategories')->getCategories(),
        ));
    }

    /**
     * Displays a form to edit an existing Peoples entity.
     *
     */
    public function editAction(Request $request, Peoples $peoples)
    {
        $deleteForm = $this->createDeleteForm($peoples);
        $editForm = $this->createForm(new PeoplesType(), $peoples);
        $oldFile = $peoples->getLargeImage();
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $peoples->getLargeImage();
            if (!empty($file)) {
                if (file_exists($this->container->getParameter('peoples_directory').'/'.$oldFile)) {
                    unlink($this->container->getParameter('peoples_directory').'/'.$oldFile);
                }
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->container->getParameter('peoples_directory'),
                    $fileName
                );
                $peoples->setLargeImage($fileName);
            } else {
                $peoples->setLargeImage($oldFile);
            }

            $em->persist($peoples);
            $em->flush();

            return $this->redirect($this->generateUrl('peoples_index'));
        }

        return $this->render('peoples/edit.html.twig', array(
            'peoples' => $peoples,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Peoples entity.
     *
     */
    public function deleteAction(Request $request, Peoples $peoples)
    {
        $form = $this->createDeleteForm($peoples);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if (file_exists($this->container->getParameter('peoples_directory').'/'.$peoples->getLargeImage())) {
                unlink($this->container->getParameter('peoples_directory').'/'.$peoples->getLargeImage());
            }
            $em->remove($peoples);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('peoples_index'));
    }

    /**
     * Creates a form to delete a Peoples entity.
     *
     * @param Peoples $peoples The Peoples entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Peoples $peoples)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('peoples_delete', array('id' => $peoples->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
