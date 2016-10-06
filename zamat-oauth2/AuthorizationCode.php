<?php

namespace Zamat\OAuth2;

/**
 * AuthorizationCode
 */
class AuthorizationCode
{
    /**
     * @var string
     */
    protected $code;

    /**
     * @var \DateTime
     */
    protected $expires;

    /**
     * @var string
     */
    protected $user_id;

    /**
     * @var array
     */
    protected $redirect_uri;

    /**
     * @var string
     */
    protected $scope;

    /**
     * @var Client
     */
    protected $client;

    /**
     * Set code
     *
     * @param  string            $code
     * @return AuthorizationCode
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set expires
     *
     * @param  \DateTime         $expires
     * @return AuthorizationCode
     */
    public function setExpires($expires)
    {
        if (!$expires instanceof \DateTime) {
            // @see https://github.com/bshaffer/oauth2-server-bundle/issues/24
            $dateTime = new \DateTime();
            $dateTime->setTimestamp($expires);
            $expires = $dateTime;
        }

        $this->expires = $expires;

        return $this;
    }

    /**
     * Get expires
     *
     * @return \DateTime
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * Set user_id
     *
     * @param  string            $userId
     * @return AuthorizationCode
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set redirect_uri
     *
     * @param  string            $redirectUri
     * @return AuthorizationCode
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirect_uri = explode(' ', $redirectUri);

        return $this;
    }

    /**
     * Get redirect_uri
     *
     * @return array
     */
    public function getRedirectUri()
    {
        return $this->redirect_uri;
    }

    /**
     * Set scope
     *
     * @param  string            $scope
     * @return AuthorizationCode
     */
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Get scope
     *
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set client
     *
     * @param  \OAuth2\ServerBundle\Entity\Client $client
     * @return AuthorizationCode
     */
    public function setClient(Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }
}