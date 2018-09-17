<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Colour;
use AppBundle\Form\ColourType;

/**
 * Colour controller.
 *
 */
class ColourController extends Controller
{

    /**
     * Lists all Colour entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Colour')->findAll();

        return $this->render('AppBundle:Colour:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Colour entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Colour();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_colour_show', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:Colour:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Colour entity.
     *
     * @param Colour $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Colour $entity)
    {
        $form = $this->createForm(new ColourType(), $entity, array(
            'action' => $this->generateUrl('admin_colour_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Colour entity.
     *
     */
    public function newAction()
    {
        $entity = new Colour();
        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:Colour:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Colour entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Colour')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Colour entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Colour:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Colour entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Colour')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Colour entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Colour:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Colour entity.
    *
    * @param Colour $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Colour $entity)
    {
        $form = $this->createForm(new ColourType(), $entity, array(
            'action' => $this->generateUrl('admin_colour_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Colour entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Colour')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Colour entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_colour_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:Colour:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Colour entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Colour')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Colour entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_colour'));
    }

    /**
     * Creates a form to delete a Colour entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_colour_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
