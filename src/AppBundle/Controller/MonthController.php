<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Month;

/**
 * Month controller.
 *
 */
class MonthController extends Controller
{
    /**
     * Finds and displays a Month entity.
     *
     */
    public function showAction(Request $request, Month $month)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM AppBundle:Download a where a.month = {$month->getId()}";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        $year = $em->getRepository('AppBundle:Year')->findAll();

        return $this->render('month/show.html.twig', array(
            'pagination' => $pagination,
            'categories' => $this->get('app.services.getCategories')->getCategories(),
            'year' => $year,
        ));
    }
}
