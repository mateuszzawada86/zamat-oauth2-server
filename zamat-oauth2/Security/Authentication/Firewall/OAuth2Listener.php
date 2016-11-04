<?php

namespace Zamat\OAuth2\Security\Authentication\Firewall;

use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Http\Session\SessionAuthenticationStrategyInterface;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

use Zamat\OAuth2\Security\Authentication\Token\OAuth2Token;
use Zamat\OAuth2\Client\OAuthClientInterface;

class OAuth2Listener extends AbstractAuthenticationListener
{

    /**
     *
     * @var type 
     */
    private $clientId;
    private $clientSecret;
    private $scope;
    private $redirectUri;
    private $validateSSL;
    
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
     * @param TokenStorageInterface $tokenStorage
     * @param AuthenticationManagerInterface $authenticationManager
     * @param SessionAuthenticationStrategyInterface $sessionStrategy
     * @param HttpUtils $httpUtils
     * @param type $providerKey
     * @param AuthenticationSuccessHandlerInterface $successHandler
     * @param AuthenticationFailureHandlerInterface $failureHandler
     * @param array $options
     * @param LoggerInterface $logger
     * @param EventDispatcherInterface $dispatcher
     * @param OAuthClientInterface $client
     */
    public function __construct(TokenStorageInterface $tokenStorage,AuthenticationManagerInterface $authenticationManager,SessionAuthenticationStrategyInterface $sessionStrategy, HttpUtils $httpUtils, $providerKey, AuthenticationSuccessHandlerInterface $successHandler, AuthenticationFailureHandlerInterface $failureHandler, array $options = array(),LoggerInterface $logger = null, EventDispatcherInterface $dispatcher = null,OAuthClientInterface $client = null )
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
        
        $this->handleOAuthError($request);
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
            'scope' => $this->scope,
            'redirect_uri' => $this->redirectUri,
            'code' => $request->query->get('code'),
        ));
        
        if (!is_array($token) || empty($token)) {
            return null;
        }       
        return $this->generateToken($token);
        
    }
    
    /**
     * 
     * @param array $token
     * @return type
     */
    protected function generateToken(array $token)
    {

        $oauth2Token = new OAuth2Token();
        $oauth2Token->setAccessToken($token['access_token']);
        $oauth2Token->setRefreshToken($token['refresh_token']);
        $oauth2Token->setExpires($token['expires_in']);
        $oauth2Token->setRawToken(json_encode($token));

        return $this->authenticationManager->authenticate($oauth2Token);
    }
    
    /**
     * Detects errors returned by resource owners and transform them into
     * human readable messages
     * @param Request $request
     * @throws AuthenticationException
     */
    private function handleOAuthError(Request $request)
    {
        if ($request->query->has('error') || $request->query->has('error_code')) {
            if ($request->query->has('error_description') || $request->query->has('error_message')) {
                throw new AuthenticationException(rawurldecode($request->query->get('error_description', $request->query->get('error_message'))));
            }
        }
        return $this;
    }
 

}
