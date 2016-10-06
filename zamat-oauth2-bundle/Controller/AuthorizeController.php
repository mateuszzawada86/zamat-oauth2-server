<?php

namespace Zamat\Bundle\OAuth2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class AuthorizeController extends Controller
{
    /**
     * @Route("/authorize", name="_oauth_authorize_validate")
     * @Method({"GET"})
     * @Template("ZamatOAuth2Bundle:Authorize:authorize.html.twig")
     */
    public function validateAuthorizeAction()
    {
        $server  = $this->get('zamat_oauth2.server');
        $request = $this->get('zamat_oauth2.request');
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
     * @Route("/authorize", name="_oauth_authorize_handle")
     * @Method({"POST"})
     */
    public function handleAuthorizeAction()
    {
        $server = $this->get('oauth2.server');
        $request = $this->get('zamat_oauth2.request');
        $response = $this->get('zamat_oauth2.response');
        
        return $server->handleAuthorizeRequest($request,$response, true);
    }
}
