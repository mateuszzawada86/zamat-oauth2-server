<?php

namespace Zamat\OAuth2;


/**
 * Client
 */
class ClientPublicKey
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var integer
     */
    protected $client_id;

    /**
     * @var string
     */
    protected $public_key;

    /**
     * Set client
     *
     * @param  \OAuth2\ServerBundle\Entity\Client $client
     * @return ClientPublicKey
     */
    public function setClient(Client $client = null)
    {
        $this->client = $client;

        // this is necessary as the client_id is the primary key
        $this->client_id = $client->getClientId();

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

    /**
     * Set public key
     *
     * @param  string  $public_key
     * @return Client
     */
    public function setPublicKey($public_key)
    {
        $this->public_key = $public_key;

        return $this;
    }

    /**
     * Get public key
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->public_key;
    }
}
