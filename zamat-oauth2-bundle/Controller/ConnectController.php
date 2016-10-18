<?php

namespace Zamat\Bundle\OAuth2Bundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Zamat\Mvc\Controller\BaseController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class ConnectController extends Controller
{
    /**
     * This is called by the client app once the client has obtained
     * an authorization code from the Authorize Controller (@see OAuth2\ServerBundle\Controller\AuthorizeController).
     * returns a JSON-encoded Access Token or a JSON object with
     * "error" and "error_description" properties.
     * @Route("/oauth/v2/connect", name="_oauth_connect")
     * @Method({"GET"})
     * @Template("ZamatOAuth2Bundle:Connect:connect.html.twig")
     */
    public function connectAction()
    {
        return array();   
    }
       
    /**
     * @Route("/oauth/v2/connect", name="_oauth_connect_service")
     * @Method({"POST"})
     */
    public function connectServiceAction(Request $request)
    {              
        $oauthClient = $this->get('oauth.client');                    
        $authorizationUrl = $oauthClient->generateAuthorizationUrl();
                
        if ($request->hasSession()) {
            $session = $request->getSession();
            $session->start();
            if (!$session->has('zamat_oauth_authorization') && ($targetUrl = $request->headers->get('Referer')) && $targetUrl !== $authorizationUrl) {
                $session->set('zamat_oauth_authorization', $targetUrl);
            }
        }
        $this->redirect($authorizationUrl)->sendHeaders();
        return new RedirectResponse($authorizationUrl);
    }  
    
    /**
     * This is called by the client app once the client has obtained
     * an authorization code from the Authorize Controller (@see OAuth2\ServerBundle\Controller\AuthorizeController).
     * returns a JSON-encoded Access Token or a JSON object with
     * "error" and "error_description" properties.
     * @Route("/oauth/v2/check", name="_oauth_connect_check")
     * @Method({"GET"})
     */
    public function checkAction()
    {              
        $oauthClient = $this->get('oauth.client');            
        $accessToken = $oauthClient->getAccessToken();  
        return new JsonResponse($accessToken);

    }  

}
