<?php

namespace Zamat\OAuth2\Client;

class OAuthParameters
{

    /**
     *
     * @var type 
     */
    private $authorizeUrl;

    /**
     *
     * @var type 
     */
    private $tokenUrl;

    /**
     *
     * @var type 
     */
    private $checkUrl;

    /**
     *
     * @var type 
     */
    private $connectUrl;

    /**
     * 
     * @param array $parameters
     */
    public function __construct(array $parameters = array())
    {
        $this->authorizeUrl = $parameters['authorizeUrl'];
        $this->tokenUrl = $parameters['tokenUrl'];
        $this->checkUrl = $parameters['checkUrl'];
        $this->connectUrl = $parameters['connectUrl'];
    }

    /**
     * 
     * @return type
     */
    public function getAuthorizeUrl()
    {
        return $this->authorizeUrl;
    }

    /**
     * 
     * @return type
     */
    public function getTokenUrl()
    {
        return $this->tokenUrl;
    }

    /**
     * 
     * @return type
     */
    public function getCheckUrl()
    {
        return $this->checkUrl;
    }

    /**
     * 
     * @return type
     */
    public function getConnectUrl()
    {
        return $this->connectUrl;
    }

}
