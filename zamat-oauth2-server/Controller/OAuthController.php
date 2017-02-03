<?php

namespace Zamat\Bundle\OAuth2ServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class OAuthController extends Controller
{
    /**
     * @Route("/", name="_oauth")
     * @Method({"GET"})
     * @Template("ZamatOAuth2ServerBundle:OAuth:oauth.html.twig")
     */
    public function oAuthAction()
    {
    }
       
}
