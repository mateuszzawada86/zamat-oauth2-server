<?php

namespace Zamat\Bundle\OAuth2Bundle\Controller;

use Zamat\Mvc\Controller\BaseController as Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class OAuthController extends Controller
{
    /**
     * @Route("/", name="_oauth")
     * @Method({"GET"})
     * @Template("ZamatOAuth2Bundle:OAuth:oauth.html.twig")
     */
    public function oAuthAction()
    {
    }
    
    /**
     * @Route("/oauth", name="_oauth_secured")
     * @Method({"GET"})
     * @Template("ZamatOAuth2Bundle:OAuth:oauth.html.twig")
     */
    public function oAuthSecuredAction()
    {
    }   
    
}
