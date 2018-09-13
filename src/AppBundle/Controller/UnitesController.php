<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Unites;
use AppBundle\Entity\Buimage;
use AppBundle\Form\UnitesType;

/**
 * Unites controller.
 *
 */
class UnitesController extends Controller
{
    /**
     * Lists all Unites entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM AppBundle:Unites a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        $unites = $em->getRepository('AppBundle:Unites')->findAll();
        $deleteForms = array();

        foreach ($unites as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        }

        return $this->render('unites/index.html.twig', array(
            'pagination' => $pagination,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new Unites entity.
     *
     */
    public function newAction(Request $request)
    {
        $unite = new Unites();
        $form = $this->createForm(new UnitesType(), $unite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $unite->getLargeImage();
            if (!empty($file)) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                  $this->container->getParameter('unites_directory'),
                  $fileName
              );
            } else {
                $fileName = 'media-img.png';
            }
            $unite->setLargeImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $count = $request->request->get('unites');
            for ($i = 1; $i <= $count['fileCount']; $i++) {
                $buimage = new Buimage();
                $file =  $request->files->get('unites');
                if (!empty($file['anotherImage'.$i])) {
                    $fileName = md5(uniqid()).'.'.$file['anotherImage'.$i]->guessExtension();
                    $file['anotherImage'.$i]->move(
                      $this->container->getParameter('buimage_directory'),
                      $fileName
                  );
                    $buimage->setCreatedAt(new \DateTime());
                    $buimage->setLargeImage($fileName);
                    $buimage->setUnites($unite);
                    $em->persist($buimage);
                }
            }
            $url = $unite->getWebUrl();
            if (!empty($url)) {
                if (strtolower(substr($unite->getWebUrl(), 0, 4)) != 'http') {
                    $url = 'http://'.$unite->getWebUrl();
                    $unite->setWebUrl($url);
                }
            }
            $em->persist($unite);
            $em->flush();

            return $this->redirect($this->generateUrl('unites_index'));
        }

        return $this->render('unites/new.html.twig', array(
            'unite' => $unite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Unites entity.
     *
     */
    public function showAction(Unites $unite)
    {
        $deleteForm = $this->createDeleteForm($unite);

        return $this->render('unites/show.html.twig', array(
            'unite' => $unite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a Unites entity.
     *
     */
    public function showPublicAction(Unites $unite)
    {
        return $this->render('unites/showPublic.html.twig', array(
            'unite' => $unite,
            'categories' => $this->get('app.services.getCategories')->getCategories(),
        ));
    }

    /**
     * Displays a form to edit an existing Unites entity.
     *
     */
    public function editAction(Request $request, Unites $unite)
    {
        $deleteForm = $this->createDeleteForm($unite);
        $images = $unite->getUnitesImage();
        $editForm = $this->createForm(new UnitesType(), $unite);
        $oldFile = $unite->getLargeImage();

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $count = $request->request->get('unites');
            for ($i = 1; $i <= $count['fileCount']; $i++) {
                $buimage = new Buimage();
                $file =  $request->files->get('unites');
                if (!empty($file['anotherImage'.$i])) {
                    foreach ($images as $image) {
                        $fileName = $image->getLargeImage();
                        $filePath = $this->container->getParameter('buimage_directory').'/'.$fileName;
                        if (file_exists($filePath) && !empty($fileName)) {
                            unlink($this->container->getParameter('buimage_directory').'/'.$image->getLargeImage());
                            $em->remove($image);
                            // $em->flush();
                        }
                    }
                    $fileName = md5(uniqid()).'.'.$file['anotherImage'.$i]->guessExtension();
                    $file['anotherImage'.$i]->move(
                        $this->container->getParameter('buimage_directory'),
                        $fileName
                    );
                    $buimage->setCreatedAt(new \DateTime());
                    $buimage->setLargeImage($fileName);
                    $buimage->setUnites($unite);
                    $em->persist($buimage);
                    // $em->flush();
                }
            }
            $filePath = $this->container->getParameter('unites_directory').'/'.$oldFile;
            $fileName = $unite->getLargeImage();
            if (file_exists($filePath) && !empty($fileName)) {
                unlink($this->container->getParameter('unites_directory').'/'.$oldFile);
                $file = $unite->getLargeImage();
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->container->getParameter('unites_directory'),
                    $fileName
                );
                $unite->setLargeImage($fileName);
            } else {
                $unite->setLargeImage($oldFile);
            }
            $url = $unite->getWebUrl();
            if (!empty($url)) {
                if (strtolower(substr($unite->getWebUrl(), 0, 4)) != 'http') {
                    $url = 'http://'.$unite->getWebUrl();
                    $unite->setWebUrl($url);
                }
            }
            $em->persist($unite);
            $em->flush();

            return $this->redirect($this->generateUrl('unites_index'));
        }

        return $this->render('unites/edit.html.twig', array(
            'unite' => $unite,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Unites entity.
     *
     */
    public function deleteAction(Request $request, Unites $unite)
    {
        $form = $this->createDeleteForm($unite);
        $images = $unite->getUnitesImage();
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($images as $image) {
                $fileName = $image->getLargeImage();
                $filePath = $this->container->getParameter('buimage_directory').'/'.$fileName;
                if (file_exists($filePath) && !empty($fileName)) {
                    unlink($this->container->getParameter('buimage_directory').'/'.$image->getLargeImage());
                    $em->remove($image);
                    $em->flush();
                }
            }
            $em = $this->getDoctrine()->getManager();
            $fileName = $unite->getLargeImage();
            $filePath = $this->container->getParameter('unites_directory').'/'.$unite->getLargeImage();
            if (file_exists($filePath) && !empty($fileName)) {
                unlink($this->container->getParameter('unites_directory').'/'.$unite->getLargeImage());
            }
            $em->remove($unite);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('unites_index'));
    }

    /**
     * Creates a form to delete a Unites entity.
     *
     * @param Unites $unite The Unites entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Unites $unite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('unites_delete', array('id' => $unite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
    * Search Unites Action
    * @param string
    */
    public function searchAction(Request $request)
    {
        $searchTerm = $request->query->get('search');

        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM AppBundle:Unites a where a.story like '%{$searchTerm}%'";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );


        return $this->render('unites/search.html.twig', array(
            'pagination' => $pagination,
            'categories' => $this->get('app.services.getCategories')->getCategories(),
        ));
    }
}
