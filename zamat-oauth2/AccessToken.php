<?php

namespace Zamat\OAuth2;

class AccessToken
{

    /**
     * @var string
     */
    protected $token;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var \DateTime
     */
    protected $expires;

    /**
     * @var string
     */
    protected $scope;

    /**
     * @var Client
     */
    protected $client;

    /**
     * Set token
     *
     * @param  string $token
     * @return AccessToken
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set user
     * @param  UserInterface $user
     * @return AccessToken
     */
    public function setUser(UserInterface $user = null)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set expires
     *
     * @param  \DateTime   $expires
     * @return AccessToken
     */
    public function setExpires($expires)
    {
        if (!$expires instanceof \DateTime) {
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
     * Set scope
     *
     * @param  string $scope
     * @return AccessToken
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
     * @param  Client $client
     * @return AccessToken
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
