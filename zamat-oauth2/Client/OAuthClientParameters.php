<?php

namespace Zamat\OAuth2\Client;


class OAuthClientParameters
{

    /**
     *
     * @var type 
     */
    private $client;

    /**
     *
     * @var type 
     */
    private $clientSecret;
    

    /**
     *
     * @var array 
     */
    private $scopes;  
    
    /**
     *
     * @var array 
     */
    private $redirectUrl;  

    /**
     * 
     * @param array $parameters
     */
    public function __construct(array $parameters = array())
    {
        $this->client = $parameters['client'];
        $this->clientSecret = $parameters['clientSecret'];
        $this->scopes = $parameters['scopes'];
        $this->redirectUrl = $parameters['redirectUri'];
    }

    /**
     * 
     * @return type
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * 
     * @return type
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }
    
    /**
     * 
     * @return array
     */
    public function getScopes()
    {
        return $this->scopes;
    }
    
    /**
     * 
     * @return type
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

}
