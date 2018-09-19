<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Unites;
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
        $unites = $em->getRepository('AppBundle:Unites')->findBy(array(), array('id' => 'ASC'), 12);
        $product1 = $em->getRepository('AppBundle:Unites')->findBy(array(), array('id' => 'DESC'), 4);
        $product2 = $em->getRepository('AppBundle:Unites')->findBy(array(), array('id' => 'ASC'), 4);
        $product3 = $em->getRepository('AppBundle:Unites')->findBy(array(), array('title' => 'DESC'), 4);
        $qtitle = $em->getRepository('AppBundle:Quote')->findBy(array('id' => 2));
        $qconten = $em->getRepository('AppBundle:Quote')->findBy(array('id' => 1));
        return $this->render('default/index.html.twig', array(
             'unites' => $unites,
             'qtitle' => $qtitle,
             'product1' => $product1,
             'product2' => $product2,
             'product3' => $product3,
             'qconten' => $qconten,
             'categories' => $this->get('app.services.getCategories')->getCategories(),
         ));
    }
}
