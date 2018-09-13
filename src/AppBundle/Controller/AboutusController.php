<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Aboutus;
use AppBundle\Entity\Aboutusimage;
use AppBundle\Form\AboutusType;

/**
 * Aboutus controller.
 *
 */
class AboutusController extends Controller
{
    /**
     * Lists all Aboutus entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM AppBundle:Aboutus a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        $aboutus = $em->getRepository('AppBundle:Aboutus')->findAll();
        $deleteForms = array();

        foreach ($aboutus as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        }

        return $this->render('aboutus/index.html.twig', array(
            'pagination' => $pagination,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new Aboutus entity.
     *
     */
    public function newAction(Request $request)
    {
        $aboutus = new Aboutus();
        $form = $this->createForm(new AboutusType(), $aboutus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $aboutus->getLargeImage();
            if (!empty($file)) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->container->getParameter('aboutus_directory'),
                    $fileName
                );
            } else {
                $fileName = 'media-img.png';
            }
            $aboutus->setLargeImage($fileName);
            $data = $request->request->get('aboutus');
            $dataF = $request->files->get('aboutus');
            for ($i = 1; $i <= $data['fileCount']; $i++) {
                $abimage = new Aboutusimage();
                $file =  $dataF['anotherImage'.$i];
                if (!empty($file)) {
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move(
                      $this->container->getParameter('aboutusimage_directory'),
                      $fileName
                  );
                    $abimage->setCreatedAt(new \DateTime());
                    $abimage->setLargeImage($fileName);
                    $abimage->setAboutus($aboutus);
                    $em->persist($abimage);
                }
            }
            $em->persist($aboutus);
            $em->flush();

            return $this->redirect($this->generateUrl('aboutus_index'));
        }

        return $this->render('aboutus/new.html.twig', array(
            'aboutus' => $aboutus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Aboutus entity.
     *
     */
    public function showAction(Aboutus $aboutus)
    {
        $deleteForm = $this->createDeleteForm($aboutus);

        return $this->render('aboutus/show.html.twig', array(
            'aboutus' => $aboutus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a Aboutus entity.
     *
     */
    public function showPublicAction(Aboutus $aboutus)
    {
        return $this->render('aboutus/showPublic.html.twig', array(
            'aboutus' => $aboutus,
            'categories' => $this->get('app.services.getCategories')->getCategories(),
        ));
    }

    /**
     * Displays a form to edit an existing Aboutus entity.
     *
     */
    public function editAction(Request $request, Aboutus $aboutus)
    {
        $deleteForm = $this->createDeleteForm($aboutus);
        $images = $aboutus->getAboutusImage();
        $editForm = $this->createForm(new AboutusType(), $aboutus);
        $oldFile = $aboutus->getLargeImage();

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $request->request->get('aboutus');
            $dataF = $request->files->get('aboutus');
            for ($i = 1; $i <= $data['fileCount']; $i++) {
                $abimage = new Aboutusimage();
                $file =  $dataF['anotherImage'.$i];
                if (!empty($file)) {
                    foreach ($images as $image) {
                        $fileName = $image->getLargeImage();
                        $filePath = $this->container->getParameter('aboutusimage_directory').'/'.$fileName;
                        if (file_exists($filePath) && !empty($fileName)) {
                            unlink($this->container->getParameter('aboutusimage_directory').'/'.$image->getLargeImage());
                            $em->remove($image);
                            $em->flush();
                        }
                    }
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move(
                        $this->container->getParameter('aboutusimage_directory'),
                        $fileName
                    );
                    $abimage->setCreatedAt(new \DateTime());
                    $abimage->setLargeImage($fileName);
                    $abimage->setAboutus($aboutus);
                    $em->persist($abimage);
                    $em->flush();
                }
            }
            $filePath = $this->container->getParameter('aboutus_directory').'/'.$oldFile;
            $fileName = $aboutus->getLargeImage();
            if (file_exists($filePath) && !empty($fileName)) {
                unlink($this->container->getParameter('aboutus_directory').'/'.$oldFile);
                $file = $aboutus->getLargeImage();
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->container->getParameter('aboutus_directory'),
                    $fileName
                );
                $aboutus->setLargeImage($fileName);
            } else {
                $aboutus->setLargeImage($oldFile);
            }
            $em->persist($aboutus);
            $em->flush();

            return $this->redirect($this->generateUrl('aboutus_index'));
        }

        return $this->render('aboutus/edit.html.twig', array(
            'aboutus' => $aboutus,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Aboutus entity.
     *
     */
    public function deleteAction(Request $request, Aboutus $aboutus)
    {
        $form = $this->createDeleteForm($aboutus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($aboutus);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('aboutus_index'));
    }

    /**
     * Creates a form to delete a Aboutus entity.
     *
     * @param Aboutus $aboutus The Aboutus entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Aboutus $aboutus)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aboutus_delete', array('id' => $aboutus->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
