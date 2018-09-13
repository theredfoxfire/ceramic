<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Csr;
use AppBundle\Entity\Csrimage;
use AppBundle\Form\CsrType;

/**
 * Csr controller.
 *
 */
class CsrController extends Controller
{
    /**
     * Lists all Csr entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM AppBundle:Csr a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        $csr = $em->getRepository('AppBundle:Csr')->findAll();
        $deleteForms = array();

        foreach ($csr as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        }

        return $this->render('csr/index.html.twig', array(
            'pagination' => $pagination,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new Csr entity.
     *
     */
    public function newAction(Request $request)
    {
        $csr = new Csr();
        $form = $this->createForm(new CsrType(), $csr);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $csr->getLargeImage();
            if (!empty($file)) {
              $fileName = md5(uniqid()).'.'.$file->guessExtension();
              $file->move(
                  $this->container->getParameter('csr_directory'),
                  $fileName
              );
              $csr->setLargeImage($fileName);
            }

            $em = $this->getDoctrine()->getManager();
            $count = $request->request->get('csr');
            for ($i = 1; $i <= $count['fileCount']; $i++) {
              $csrimage = new Csrimage();
              $file =  $request->files->get('csr');
              if (!empty($file['anotherImage'.$i])) {
                  $fileName = md5(uniqid()).'.'.$file['anotherImage'.$i]->guessExtension();
                  $file['anotherImage'.$i]->move(
                      $this->container->getParameter('csrimage_directory'),
                      $fileName
                  );
                  $csrimage->setCreatedAt(new \DateTime());
                  $csrimage->setLargeImage($fileName);
                  $csrimage->setCsr($csr);
                  $em->persist($csrimage);
              }
            }
            $em->persist($csr);
            $em->flush();

            return $this->redirect($this->generateUrl('csr_index'));
        }

        return $this->render('csr/new.html.twig', array(
            'csr' => $csr,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Csr entity.
     *
     */
    public function showAction(Csr $csr)
    {
        $deleteForm = $this->createDeleteForm($csr);

        return $this->render('csr/show.html.twig', array(
            'csr' => $csr,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a Csr entity.
     *
     */
    public function showPublicAction(Csr $csr)
    {

        return $this->render('csr/showPublic.html.twig', array(
            'csr' => $csr,
            'categories' => $this->get('app.services.getCategories')->getCategories(),
        ));
    }

    /**
     * Displays a form to edit an existing Csr entity.
     *
     */
    public function editAction(Request $request, Csr $csr)
    {
        $deleteForm = $this->createDeleteForm($csr);
        $images = $csr->getCsrImage();
        $editForm = $this->createForm(new CsrType(), $csr);
        $oldFile = $csr->getLargeImage();

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $count = $request->request->get('csr');
            for ($i = 1; $i <= $count['fileCount']; $i++) {
              $csrimage = new Csrimage();
              $file =  $request->files->get('csr');
                if (!empty($file['anotherImage'.$i])) {
                    foreach ($images as $image) {
                        $fileName = $image->getLargeImage();
                        $filePath = $this->container->getParameter('csrimage_directory').'/'.$file;
                        if (file_exists($filePath) && !empty($fileName)) {
                            unlink($this->container->getParameter('csrimage_directory').'/'.$image->getLargeImage());
                            $em->remove($image);
                            $em->flush();
                        }
                    }
                    $fileName = md5(uniqid()).'.'.$file['anotherImage'.$i]->guessExtension();
                    $file['anotherImage'.$i]->move(
                        $this->container->getParameter('csrimage_directory'),
                        $fileName
                    );
                    $csrimage->setCreatedAt(new \DateTime());
                    $csrimage->setLargeImage($fileName);
                    $csrimage->setCsr($csr);
                    $em->persist($csrimage);
                    $em->flush();
                }
            }
            $file =  $request->files->get('csr');
            $filePath = $this->container->getParameter('csr_directory').'/'.$oldFile;
            if (file_exists($filePath) && !empty($file['largeImage'])) {
                unlink($this->container->getParameter('csr_directory').'/'.$oldFile);
                $file = $csr->getLargeImage();
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->container->getParameter('csr_directory'),
                    $fileName
                );
                $csr->setLargeImage($fileName);
            } else {
              $csr->setLargeImage($oldFile);
            }
            $em->persist($csr);
            $em->flush();

            return $this->redirect($this->generateUrl('csr_index'));
        }

        return $this->render('csr/edit.html.twig', array(
            'csr' => $csr,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Csr entity.
     *
     */
    public function deleteAction(Request $request, Csr $csr)
    {
        $form = $this->createDeleteForm($csr);
        $images = $csr->getCsrImage();
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($images as $image) {
                $fileName = $image->getLargeImage();
                $filePath = $this->container->getParameter('csrimage_directory').'/'.$fileName;
                if (file_exists($filePath) && !empty($fileName)) {
                    unlink($this->container->getParameter('csrimage_directory').'/'.$image->getLargeImage());
                    $em->remove($image);
                    $em->flush();
                }
            }
            $em = $this->getDoctrine()->getManager();
            $fileName = $csr->getLargeImage();
            $filePath = $this->container->getParameter('csr_directory').'/'.$fileName;
            if (file_exists($filePath) && !empty($fileName)) {
                unlink($this->container->getParameter('csr_directory').'/'.$csr->getLargeImage());
            }
            $em->remove($csr);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('csr_index'));
    }

    /**
     * Creates a form to delete a Csr entity.
     *
     * @param Csr $csr The Csr entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Csr $csr)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('csr_delete', array('id' => $csr->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
