<?php

namespace Zamat\OAuth2\Security\Authentication\Firewall;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Zamat\OAuth2\Security\Authentication\Token\OAuth2Token;

class OAuth2Listener implements ListenerInterface
{

    /**
     *
     * @var TokenStorageInterface 
     */
    protected $tokenStorage;

    /**
     *
     * @var AuthenticationManagerInterface 
     */
    protected $authenticationManager;

    /**
     * 
     * @param TokenStorageInterface $tokenStorage
     * @param AuthenticationManagerInterface $authenticationManager
     */
    public function __construct(TokenStorageInterface $tokenStorage, AuthenticationManagerInterface $authenticationManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
    }

    /**
     * 
     * @param GetResponseEvent $event
     * @return type
     */
    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        /* Fetch Bearer Token */
        $authorization = $request->headers->get('Authorization');       
        $oauthRegex = '/Bearer ([^"]+)/';
        if (!$request->headers->has('Authorization') || 1 !== preg_match($oauthRegex, $request->headers->get('Authorization'), $matches)) {
            return;
        }       
             
        $token = new OAuth2Token();
        $token->setToken(explode(' ',$authorization)[1]);

        try {

            $authToken = $this->authenticationManager->authenticate($token);
            $this->tokenStorage->setToken($authToken);
            return;
        }
        catch (AuthenticationException $authenticationFailed) {

            $token = $this->tokenStorage->getToken();
            if ($token instanceof OAuth2Token && $this->providerKey === $token->getProviderKey()) {
                $this->tokenStorage->setToken(null);
            }
            return;
        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_FORBIDDEN);
        $event->setResponse($response);
        
    }

}
