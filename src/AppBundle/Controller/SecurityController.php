<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login_form")
     */
     public function loginAction(Request $request)
     {
         $session = $request->getSession();

         // get the login error if there is one
         if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
             $error = $request->attributes->get(SecurityContextInterface::AUTHENTICATION_ERROR);
         } elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
             $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
             $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
         } else {
             $error = null;
         }

         // last username entered by the user
         $lastUsername = (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);

         return $this->render(
             'security/login.html.twig',
             array(
                 // last username entered by the user
                 'last_username' => $lastUsername,
                 'error'         => $error,
             )
         );
     }

    /**
     * This is the route the login form submits to.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the login automatically. See form_login in app/config/security.yml
     *
     * @Route("/login_check", name="security_login_check")
     */
    public function loginCheckAction()
    {
        throw new \Exception('This should never be reached!');
    }

    /**
     * This is the route the user can use to logout.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the logout automatically. See logout in app/config/security.yml
     *
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        throw new \Exception('This should never be reached!');
    }
}
