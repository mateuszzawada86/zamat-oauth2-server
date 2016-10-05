<?php

namespace Zamat\Bundle\SecurityBundle\Entity\OAuth2;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="zamat_oauth2_client")
 */
class Client
{
    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    private $client_id;

    /**
     * @var string
     * @ORM\Column(type="string", length=40)
     */
    private $client_secret;

    /**
     * @var array
     * @ORM\Column(type="simple_array")
     */
    private $redirect_uri;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $grant_types;

    /**
     * @var string
     */
    private $public_key;

    /**
     * Set client_id
     *
     * @param  string $clientId
     * @return Client
     */
    public function setClientId($clientId)
    {
        $this->client_id = $clientId;

        return $this;
    }

    /**
     * Get client_id
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Set client_secret
     *
     * @param  string $clientSecret
     * @return Client
     */
    public function setClientSecret($clientSecret)
    {
        $this->client_secret = $clientSecret;

        return $this;
    }

    /**
     * Get client_secret
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     * Set redirect_uri
     *
     * @param  array  $redirectUri
     * @return Client
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirect_uri = $redirectUri;

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
     * Set grant_types
     *
     * @param  array  $grantTypes
     * @return Client
     */
    public function setGrantTypes($grantTypes)
    {
        $this->grant_types = $grantTypes;

        return $this;
    }

    /**
     * Get grant_types
     *
     * @return array
     */
    public function getGrantTypes()
    {
        return $this->grant_types;
    }
    /**
     * @var array
     */
    private $scopes;

    /**
     * Set scopes
     *
     * @param  array  $scopes
     * @return Client
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;

        return $this;
    }

    /**
     * Get scopes
     *
     * @return array
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * Set public key
     *
     * @param  \OAuth2\ServerBundle\Entity\ClientPublicKey $public_key
     * @return Client
     */
    public function setPublicKey(ClientPublicKey $public_key = null)
    {
        $this->public_key = $public_key;

        return $this;
    }

    /**
     * Get public key
     *
     * @return \OAuth2\ServerBundle\Entity\ClientPublicKey
     */
    public function getPublicKey()
    {
        return $this->public_key;
    }
}
