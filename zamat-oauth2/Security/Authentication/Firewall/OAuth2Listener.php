<?php

namespace Zamat\OAuth2\Security\Authentication\Firewall;

use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;
use Symfony\Component\HttpFoundation\Request;

use Zamat\OAuth2\Security\Authentication\Token\OAuth2Token;
use Zamat\OAuth2\Client\OAuthClientInterface;

class OAuth2Listener extends AbstractAuthenticationListener
{

    /**
     *
     * @var type 
     */
    protected $serverAuthorizeUri;
    protected $serverTokenUri;
    protected $clientId;
    protected $clientSecret;
    protected $scope;
    protected $redirectUri;
    protected $validateSSL;
    
    /**
     *
     * @var OAuthClientInterface 
     */
    protected $client;
    
    /**
     * 
     * @return OAuthClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }
    
    /**
     * 
     * @param OAuthClientInterface $client
     * @return \Zamat\OAuth2\Security\Authentication\Firewall\OAuth2Listener
     */
    public function setClient(OAuthClientInterface $client)
    {
        $this->client = $client;
        return $this;
    }
     
    /**
     * 
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface $authenticationManager
     * @param \Symfony\Component\Security\Http\Session\SessionAuthenticationStrategyInterface $sessionStrategy
     * @param \Symfony\Component\Security\Http\HttpUtils $httpUtils
     * @param type $providerKey
     * @param \Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface $successHandler
     * @param \Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface $failureHandler
     * @param array $options
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher
     * @param OAuthClientInterface $client
     */
    public function __construct(\Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage, \Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface $authenticationManager, \Symfony\Component\Security\Http\Session\SessionAuthenticationStrategyInterface $sessionStrategy, \Symfony\Component\Security\Http\HttpUtils $httpUtils, $providerKey, \Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface $successHandler, \Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface $failureHandler, array $options = array(), \Psr\Log\LoggerInterface $logger = null, \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher = null,OAuthClientInterface $client = null )
    {
        if($client) {
            $this->setClient($client);
        }
        parent::__construct($tokenStorage, $authenticationManager, $sessionStrategy, $httpUtils, $providerKey, $successHandler, $failureHandler, $options, $logger, $dispatcher);
    }

    /**
     * Set oAuth2 configuration params
     * @param array $parameters
     * @return \Zamat\OAuth2\Security\Authentication\Firewall\OAuth2Listener
     */
    public function setParameters(array $parameters = array())
    {
                
        $this->serverAuthorizeUri = $parameters['authorize_uri'];
        $this->serverTokenUri = $parameters['token_uri'];
        $this->validateSSL = $parameters['validate_ssl'];
        $this->clientId = $parameters['client_id'];
        $this->clientSecret = $parameters['client_secret'];
        $this->redirectUri = $parameters['redirect_uri'];
        $this->scope = $parameters['scope'];

        return $this;
    }

    /**
     * 
     * @param Request $request
     * @return boolean
     */
    public function requiresAuthentication(Request $request)
    {
        return true;
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    protected function attemptAuthentication(Request $request)
    {
        if (!$request->query->has('code')) {
            return null;
        }
        
        $session = $request->getSession();
        if ($session->get('state') != $request->query->get('state')) {
          return null;
        }
        
        $token = $this->getClient()->getAccessToken(array(
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'token_url' => $this->serverTokenUri,
            'scope' => $this->scope,
            'redirect_uri' => $this->redirectUri,
            'code' => $request->query->get('code'),
        ));

        if (!is_array($token) || empty($token)) {
            return null;
        }
                
        $oauth2Token = new OAuth2Token();
        
        $oauth2Token->setAccessToken($token['access_token']);
        $oauth2Token->setRefreshToken($token['refresh_token']);
        $oauth2Token->setExpires($token['expires_in']);
        $oauth2Token->setRawToken(json_encode($token));

        $authToken = $this->authenticationManager->authenticate($oauth2Token);
                
        return $authToken;
        
    }

}
