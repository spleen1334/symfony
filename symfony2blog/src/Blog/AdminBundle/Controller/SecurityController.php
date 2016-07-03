<?php

namespace Blog\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    /**
     * Login
     * 
     * @return Response
     */
    public function loginAction()
    {
        
        $request = $this->getRequest();
        $session = $request->getSession();
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        return $this->render(
            'AdminBundle:Security:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error
            )
        );

//         $authenticationUtils = $this->get('security.authentication_utils');
        
//         // get the login error if there is one
//         $error = $authenticationUtils->getLastAuthenticationError();
        
//         // last username entered by the user
//         $lastUsername = $authenticationUtils->getLastUsername();
        
//         return $this->render(
//             'AdminBundle:Security:login.html.twig',
//             array(
//                 // last username entered by the user
//                 'last_username' => $lastUsername,
//                 'error'         => $error,
//             )
//         );
    }
    
    /**
     * Login check
     */
    public function loginCheckAction()
    {
        
    }
    
    public function logoutAction()
    {
        
    }
}