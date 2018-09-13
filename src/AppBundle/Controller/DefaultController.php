<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Slide;
use AppBundle\Entity\News;
use AppBundle\Entity\Logo;
use AppBundle\Entity\Quote;
use AppBundle\Entity\Video;

class DefaultController extends Controller
{
    /**
     * @Route("/admin", name="adminHomepage")
     */
    public function adminAction(Request $request)
    {
        return $this->render('default/indexAdmin.html.twig');
    }
    /**
     * @Route("/start", name="landingPage")
     */
    public function landingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $videos = $em->getRepository('AppBundle:Video')->findAll();
        return $this->render('default/landing.html.twig', array(
            'videos' => $videos,
        ));
    }
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dqlNews   = "SELECT a FROM AppBundle:News a";
        $newsQuery = $em->createQuery($dqlNews);

        $newsPaginator  = $this->get('knp_paginator');
        $news = $newsPaginator->paginate(
             $newsQuery, /* query NOT result */
             $request->query->getInt('page', 1)/*page number*/,
             3/*limit per page*/
         );


        $slides = $em->getRepository('AppBundle:Slide')->findAll();
        $logos = $em->getRepository('AppBundle:Logo')->findAll();
        $quotes = $em->getRepository('AppBundle:Quote')->findAll();
        $abouts = $em->getRepository('AppBundle:Aboutus')->findAll();

        return $this->render('default/index.html.twig', array(
             'slides' => $slides,
             'logos' => $logos,
             'quotes' => $quotes,
             'abouts' => $abouts,
             'news' => $news,
             'categories' => $this->get('app.services.getCategories')->getCategories(),
         ));
    }
}
