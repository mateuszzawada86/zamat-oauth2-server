<?php

namespace Zamat\Bundle\OAuth2Bundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class VerifyController extends Controller
{
    /**
     * This is called with an access token, details
     * about the access token are then returned.
     * Used for verification purposes.
     * @Route("/verify", name="_verify_token")
     */
    public function verifyAction()
    {
        $server = $this->get('zamat_oauth2.server');
        if (!$server->verifyResourceRequest($this->get('zamat_oauth2.request'), $this->get('zamat_oauth2.response'))) {
            return $server->getResponse();
        }
        $tokenData = $server->getAccessTokenData($this->get('zamat_oauth2.request'), $this->get('zamat_oauth2.response'));

        return new JsonResponse($tokenData);
    }
}
