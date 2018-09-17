<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Size;
use AppBundle\Form\SizeType;

/**
 * Size controller.
 *
 */
class SizeController extends Controller
{

    /**
     * Lists all Size entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Size')->findAll();

        return $this->render('AppBundle:Size:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Size entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Size();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_size_show', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:Size:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Size entity.
     *
     * @param Size $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Size $entity)
    {
        $form = $this->createForm(new SizeType(), $entity, array(
            'action' => $this->generateUrl('admin_size_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Size entity.
     *
     */
    public function newAction()
    {
        $entity = new Size();
        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:Size:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Size entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Size')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Size entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Size:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Size entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Size')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Size entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Size:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Size entity.
    *
    * @param Size $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Size $entity)
    {
        $form = $this->createForm(new SizeType(), $entity, array(
            'action' => $this->generateUrl('admin_size_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Size entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Size')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Size entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_size_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:Size:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Size entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Size')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Size entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_size'));
    }

    /**
     * Creates a form to delete a Size entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_size_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
