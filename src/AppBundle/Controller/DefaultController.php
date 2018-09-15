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
        return $this->render('default/index.html.twig', array(
             'categories' => $this->get('app.services.getCategories')->getCategories(),
         ));
    }
}
