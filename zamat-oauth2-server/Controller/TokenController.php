<?php

namespace Zamat\Bundle\OAuth2ServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TokenController extends Controller
{
    /**
     * Generate token response
     * @Route("/oauth/v2/token", name="_oauth_token")
     */
    public function tokenAction()
    {
        $server = $this->get('zamat_oauth2.server');
               
        $server->addGrantType($this->get('zamat_oauth2.oauth2.grant_type.client_credentials'));
        $server->addGrantType($this->get('zamat_oauth2.oauth2.grant_type.authorization_code'));
        $server->addGrantType($this->get('zamat_oauth2.oauth2.grant_type.refresh_token'));
        $server->addGrantType($this->get('zamat_oauth2.oauth2.grant_type.user_credentials'));

        return $server->handleTokenRequest($this->get('zamat_oauth2.request'), $this->get('zamat_oauth2.response'));
    }
}
