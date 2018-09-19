<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Subscribe;
use AppBundle\Form\SubscribeType;

/**
 * Subscribe controller.
 *
 */
class SubscribeController extends Controller
{

    /**
     * Lists all Subscribe entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Subscribe')->findAll();

        return $this->render('AppBundle:Subscribe:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Subscribe entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Subscribe();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_subscribe_show', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:Subscribe:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    /**
     * Creates a new Subscribe entity.
     *
     * @Route("/subscribe", name="public_subscribe")
     */
    public function createPublicAction(Request $request)
    {
        $entity = new Subscribe();
        $email = $request->query->get('email');

        if ($email) {
            $em = $this->getDoctrine()->getManager();
            $entity->setEmail($email);
            $em->persist($entity);
            $em->flush();

            return $this->render('AppBundle:Subscribe:success.html.twig', array(
                'entity' => $entity,
                'categories' => $this->get('app.services.getCategories')->getCategories(),
            ));
        }

        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * Creates a form to create a Subscribe entity.
     *
     * @param Subscribe $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Subscribe $entity)
    {
        $form = $this->createForm(new SubscribeType(), $entity, array(
            'action' => $this->generateUrl('admin_subscribe_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Subscribe entity.
     *
     */
    public function newAction()
    {
        $entity = new Subscribe();
        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:Subscribe:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Subscribe entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Subscribe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subscribe entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Subscribe:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Subscribe entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Subscribe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subscribe entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Subscribe:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Subscribe entity.
    *
    * @param Subscribe $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Subscribe $entity)
    {
        $form = $this->createForm(new SubscribeType(), $entity, array(
            'action' => $this->generateUrl('admin_subscribe_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Subscribe entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Subscribe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subscribe entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_subscribe_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:Subscribe:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Subscribe entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Subscribe')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Subscribe entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_subscribe'));
    }

    /**
     * Creates a form to delete a Subscribe entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_subscribe_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
