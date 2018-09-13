<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Year;
use AppBundle\Form\YearType;

/**
 * Year controller.
 *
 */
class YearController extends Controller
{

    /**
     * Lists all Year entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Year')->findAll();

        return $this->render('AppBundle:Year:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Year entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Year();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('year_show', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:Year:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Year entity.
     *
     * @param Year $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Year $entity)
    {
        $form = $this->createForm(new YearType(), $entity, array(
            'action' => $this->generateUrl('year_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Year entity.
     *
     */
    public function newAction()
    {
        $entity = new Year();
        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:Year:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Year entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Year')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Year entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Year:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Year entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Year')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Year entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Year:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Year entity.
    *
    * @param Year $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Year $entity)
    {
        $form = $this->createForm(new YearType(), $entity, array(
            'action' => $this->generateUrl('year_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Year entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Year')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Year entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('year_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:Year:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Year entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Year')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Year entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('year'));
    }

    /**
     * Creates a form to delete a Year entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('year_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
