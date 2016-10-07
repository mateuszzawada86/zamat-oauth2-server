<?php

namespace Zamat\OAuth2\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

/**
 * OAuthToken class.
 */
class OAuth2Token extends AbstractToken
{

    /**
     * @var string
     */
    protected $token;

    /**
     * 
     * @param type $token
     * @return \Zamat\OAuth2\Security\Authentication\Token\OAuthToken
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * 
     * @return type
     */
    public function getCredentials()
    {
        return $this->token;
    }
    
    /**
     * 
     * @param type $expires
     * @return boolean
     */
    public function hasExpires()
    {
        $now = new \DateTime();
        if ($this->getToken()->getTimestamp() > $now->getTimestamp()) {
            return true;
        }
        return false;
    }

}
