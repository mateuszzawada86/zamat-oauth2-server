<?php

namespace Zamat\OAuth2\Security\EntryPoint;

use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Zamat\OAuth2\Server\OAuth2;
use Zamat\OAuth2\Exception\OAuth2AuthenticateException;

class OAuthEntryPoint implements AuthenticationEntryPointInterface
{
    
    /**
     *
     * @var type 
     */
    protected $serverService;

    /**
     * 
     * @return type
     */
    public function getServerService()
    {
        return $this->serverService;
    }

    /**
     * 
     * @param OAuth2 $serverService
     * @return \Zamat\OAuth2\Security\EnttryPoint\OAuthEntryPoint
     */
    public function setServerService(OAuth2 $serverService)
    {
        $this->serverService = $serverService;
        return $this;
    }

    /**
     * 
     * @param OAuth2 $serverService
     */
    public function __construct(OAuth2 $serverService = null)
    {
        $this->serverService = $serverService;
    }

    /**
     * 
     * @param Request $request
     * @param AuthenticationException $authException
     * @return type
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
              
        $exception = new OAuth2AuthenticateException(
            Response::HTTP_FORBIDDEN,
            'bearer',
            'realm',
            'access_denied',
            'OAuth2 authentication is required'
        );

        return $exception->getHttpResponse();
    }
}
