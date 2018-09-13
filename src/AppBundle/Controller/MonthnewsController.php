<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Monthnews;

/**
 * Monthnews controller.
 *
 */
class MonthnewsController extends Controller
{
    /**
     * Finds and displays a Monthnews entity.
     *
     */
    public function showAction(Request $request, Monthnews $month)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM AppBundle:News a where a.monthnews = {$month->getId()}";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        $year = $em->getRepository('AppBundle:Yearnews')->findAll();

        return $this->render('monthnews/show.html.twig', array(
            'pagination' => $pagination,
            'categories' => $this->get('app.services.getCategories')->getCategories(),
            'year' => $year,
        ));
    }
}
