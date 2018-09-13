<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Download;
use AppBundle\Entity\Year;
use AppBundle\Entity\Month;
use AppBundle\Form\DownloadType;

/**
 * Download controller.
 *
 */
class DownloadController extends Controller
{
    /**
     * Lists all Download entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM AppBundle:Download a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
             $query, /* query NOT result */
             $request->query->getInt('page', 1)/*page number*/,
             10/*limit per page*/
         );

        $download = $em->getRepository('AppBundle:Download')->findAll();
        $deleteForms = array();

        foreach ($download as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        }

        return $this->render('download/index.html.twig', array(
             'pagination' => $pagination,
             'deleteForms' => $deleteForms,
         ));
    }

    /**
     * Lists all Download entities.
     *
     */
    public function indexPublicAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM AppBundle:Download a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
             $query, /* query NOT result */
             $request->query->getInt('page', 1)/*page number*/,
             6/*limit per page*/
         );

        $download = $em->getRepository('AppBundle:Download')->findAll();
        $year = $em->getRepository('AppBundle:Year')->findAll();
        $deleteForms = array();

        foreach ($download as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        }

        return $this->render('download/indexPublic.html.twig', array(
             'pagination' => $pagination,
             'deleteForms' => $deleteForms,
             'categories' => $this->get('app.services.getCategories')->getCategories(),
             'year' => $year,
         ));
    }

    /**
     * Creates a new Download entity.
     *
     */
    public function newAction(Request $request)
    {
        $download = new Download();
        $form = $this->createForm(new DownloadType(), $download);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $download->getFile();
            if (!empty($file)) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->container->getParameter('download_directory'),
                    $fileName
                );
            } else {
                $fileName = 'media-img.png';
            }
            $download->setFile($fileName);
            $download->setDateTime(new \DateTime());
            $year = $em->getRepository('AppBundle:Year')->findOneByYear(date('Y'));
            $month = $em->getRepository('AppBundle:Month')->findOneByMonth(date('Y-F'));
            $newYear = new Year();
            $newMonth = new Month();
            if (empty($year)) {
                $newYear->setYear(date('Y'));
                $newMonth->setYear($newYear);
                $em->persist($newYear);
            } else {
                $newMonth->setYear($year);
            }
            if (empty($month)) {
                $newMonth->setMonth(date('Y-F'));
                $newMonth->setName(date('F'));
                $download->setMonth($newMonth);
                $em->persist($newMonth);
            } else {
                $download->setMonth($month);
            }
            $download->setPostedBy($this->getUser()->getUsername());
            $em->persist($download);
            $em->flush();

            return $this->redirect($this->generateUrl('download_index'));
        }

        return $this->render('download/new.html.twig', array(
            'download' => $download,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Download entity.
     *
     */
    public function showAction(Download $download)
    {
        $deleteForm = $this->createDeleteForm($download);

        return $this->render('download/show.html.twig', array(
            'download' => $download,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a Download entity.
     *
     */
    public function showPublicAction(Download $download)
    {
        $deleteForm = $this->createDeleteForm($download);

        return $this->render('download/showPublic.html.twig', array(
            'download' => $download,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Download entity.
     *
     */
    public function editAction(Request $request, Download $download)
    {
        $deleteForm = $this->createDeleteForm($download);
        $editForm = $this->createForm(new DownloadType(), $download);
        $oldFile = $download->getFile();
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $download->getFile();
            if (!empty($file)) {
                if (file_exists($this->container->getParameter('download_directory').'/'.$oldFile)) {
                    unlink($this->container->getParameter('download_directory').'/'.$oldFile);
                }
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->container->getParameter('download_directory'),
                    $fileName
                );
                $download->setFile($fileName);
            } else {
                $download->setFile($oldFile);
            }

            $em->persist($download);
            $em->flush();

            return $this->redirect($this->generateUrl('download_index'));
        }

        return $this->render('download/edit.html.twig', array(
            'download' => $download,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Download entity.
     *
     */
    public function deleteAction(Request $request, Download $download)
    {
        $form = $this->createDeleteForm($download);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if (file_exists($this->container->getParameter('download_directory').'/'.$download->getFile())) {
                unlink($this->container->getParameter('download_directory').'/'.$download->getFile());
            }
            $em->remove($download);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('download_index'));
    }

    /**
     * Creates a form to delete a Download entity.
     *
     * @param Download $download The Download entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Download $download)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('download_delete', array('id' => $download->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
