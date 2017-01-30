<?php

namespace Zamat\OAuth2\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;
use Symfony\Component\Security\Core\Role\Role;

/**
 * OAuth2Token class.
 */
class OAuth2Token extends AbstractToken
{

    /**
     * @var string
     */
    protected $accessToken;

    /**
     *
     * @var type 
     */
    protected $refreshToken;

    /**
     *
     * @var type 
     */
    protected $rawToken;

    /**
     *
     * @var type 
     */
    protected $expires;

    /**
     * 
     * @param array $roles
     */
    public function __construct(array $roles = array())
    {
        parent::__construct($roles);
        $this->setAuthenticated(count($roles) > 0);
    }

    /**
     * 
     * @return type
     */
    public function getCredentials()
    {
        return null;
    }

    /**
     * 
     * @return type
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * 
     * @return type
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * 
     * @return type
     */
    public function getRawToken()
    {
        return $this->rawToken;
    }

    /**
     * 
     * @param type $accessToken
     * @return \Zamat\OAuth2\Security\Authentication\Token\OAuth2Token
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * 
     * @param type $refreshToken
     * @return \Zamat\OAuth2\Security\Authentication\Token\OAuth2Token
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
        return $this;
    }

    /**
     * 
     * @param type $rawToken
     * @return \Zamat\OAuth2\Security\Authentication\Token\OAuth2Token
     */
    public function setRawToken($rawToken)
    {
        $this->rawToken = $rawToken;
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * 
     * @param type $expires
     * @return \Zamat\OAuth2\Security\Authentication\Token\OAuth2Token
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getRoles()
    {
        if (empty($this->roles)) {
            return array(new Role('ROLE_USER'));
        }
        return parent::getRoles();
    }

    /**
     * 
     * @param type $expires
     * @return boolean
     */
    public function hasExpires()
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $interval = $now->diff($this->getExpires());
        $difference = $interval->format('s');
        return ($difference < 0) ? 0 : $difference;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize(array($this->accessToken, $this->refreshToken, $this->expires, parent::serialize()));
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        list($this->accessToken, $this->refreshToken, $this->expires, $parentStr) = unserialize($serialized);
        parent::unserialize($parentStr);
    }

}
