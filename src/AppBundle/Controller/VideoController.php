<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Video;
use AppBundle\Form\VideoType;

/**
 * Video controller.
 *
 */
class VideoController extends Controller
{
    /**
     * Lists all Video entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM AppBundle:Video a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
             $query, /* query NOT result */
             $request->query->getInt('page', 1)/*page number*/,
             10/*limit per page*/
         );

        $video = $em->getRepository('AppBundle:Video')->findAll();
        $deleteForms = array();

        foreach ($video as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        }

        return $this->render('video/index.html.twig', array(
             'pagination' => $pagination,
             'deleteForms' => $deleteForms,
         ));
    }

    /**
     * Creates a new Video entity.
     *
     */
    public function newAction(Request $request)
    {
        $video = new Video();
        $form = $this->createForm(new VideoType(), $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $video->getLargeImage();
            if (!empty($file)) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                 $this->container->getParameter('video_directory'),
                 $fileName
             );
            } else {
                $fileName = 'media-img.png';
            }
            $video->setCreatedAt(new \DateTime());
            $video->setLargeImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();

            return $this->redirect($this->generateUrl('video_show', array('id' => $video->getId())));
        }

        return $this->render('video/new.html.twig', array(
             'video' => $video,
             'form' => $form->createView(),
         ));
    }

    /**
     * Finds and displays a Video entity.
     *
     */
    public function showAction(Video $video)
    {
        $deleteForm = $this->createDeleteForm($video);

        return $this->render('video/show.html.twig', array(
            'video' => $video,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Video entity.
     *
     */
    public function editAction(Request $request, Video $video)
    {
        $deleteForm = $this->createDeleteForm($video);
        $editForm = $this->createForm(new VideoType(), $video);
        $oldFile =  $video->getLargeImage();

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if (file_exists($this->container->getParameter('video_directory').'/'.$oldFile)) {
                unlink($this->container->getParameter('video_directory').'/'.$oldFile);
            }
            $file =  $video->getLargeImage();
            if (!empty($file)) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                 $this->container->getParameter('video_directory'),
                 $fileName
             );
                $video->setLargeImage($fileName);
            } else {
                $video->setLargeImage($oldFile);
            }
            $em->persist($video);
            $em->flush();

            return $this->redirect($this->generateUrl('video_edit', array('id' =>  $video->getId())));
        }

        return $this->render('video/edit.html.twig', array(
             'video' => $video,
             'edit_form' => $editForm->createView(),
             'delete_form' => $deleteForm->createView(),
         ));
    }

    /**
     * Deletes a Video entity.
     *
     */
    public function deleteAction(Request $request, Video $video)
    {
        $form = $this->createDeleteForm($video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if (file_exists($this->container->getParameter('video_directory').'/'.$video->getLargeImage())) {
                unlink($this->container->getParameter('video_directory').'/'.$video->getLargeImage());
            }
            $em->remove($video);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('video_index'));
    }

    /**
     * Creates a form to delete a Video entity.
     *
     * @param Video $video The Video entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Video $video)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('video_delete', array('id' => $video->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
