<?php

namespace Zamat\Bundle\OAuth2ServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AuthorizeController extends Controller
{
    /**
     * @Route("/oauth/v2/authorize", name="_oauth_authorize_validate")
     * @Method({"GET"})
     * @Template("ZamatOAuth2ServerBundle:Authorize:authorize.html.twig")
     */
    public function validateAuthorizeAction()
    {
        
        $user = $this->getUser();
        if (!$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }      
        
        $server   = $this->get('zamat_oauth2.server');
        $request  = $this->get('zamat_oauth2.request');                
        $response = $this->get('zamat_oauth2.response');       
        if (!$server->validateAuthorizeRequest($request,$response)) {
            return $server->getResponse();
        }  
           
        $scopes = array();
        $scopeStorage = $this->get('zamat_oauth.scope.storage');
        foreach (explode(' ', $request->query->get('scope')) as $scope) {
            $scopes[] = $scopeStorage->getDescriptionForScope($scope);
        }
        return array('request' => $request->query->all(), 'scopes' => $scopes);
    }
    
    /**
     * @Route("/oauth/v2/authorize", name="_oauth_authorize_handle")
     * @Method({"POST"})
     */
    public function handleAuthorizeAction()
    {
        $user = $this->getUser();
        if (!$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }                
        $server   = $this->get('zamat_oauth2.server');
        $request  = $this->get('zamat_oauth2.request');
        $response = $this->get('zamat_oauth2.response');     
        
        return $server->handleAuthorizeRequest($request,$response, (bool) $request->request->get('authorize') , $user->getUsername());
    } 
      

    /**
     * @Route("/oauth/v2/login", name="_oauth_authorize_login")
     */
    public function loginAction()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $session = $request->getSession();  
        
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();       
        
        if ($session->has('_security.target_path')) {
            if (false !== strpos($session->get('_security.target_path'), $this->generateUrl('_oauth_authorize_handle'))) {
                $session->set('_zamat_oauth_server.ensure_logout', true);
            }
        }              
        return $this->render('ZamatOAuth2ServerBundle:Secure:login.html.twig',array(
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        ); 

    }      

    /**
     * @Route("/oauth/v2/login_check", name="_oauth_authorize_login_check")
     */
    public function loginCheckAction()
    {
    } 
    
    /**
     * @Route("/oauth/v2/logout", name="_oauth_authorize_logout")
     */
    public function logoutAction()
    {
    }   
    

}
