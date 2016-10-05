<?php

namespace Zamat\Bundle\SecurityBundle\Entity\OAuth2;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="zamat_oauth2_access_token")
 */
class AccessToken
{
    /**
     * @var string
     * @ORM\Column(type="string", length=40)
     */
    private $token;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $user_id;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $expires;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)

     */
    private $scope;

    /**
     * @var \OAuth2\ServerBundle\Entity\Client
     */
    private $client;

    /**
     * Set token
     *
     * @param  string      $token
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
     * Set user_id
     *
     * @param  string      $userId
     * @return AccessToken
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
     * Set expires
     *
     * @param  \DateTime   $expires
     * @return AccessToken
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
     * Set scope
     *
     * @param  string      $scope
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
     * @param  \OAuth2\ServerBundle\Entity\Client $client
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
     * @return \OAuth2\ServerBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }
}
