<?php

namespace Zamat\Bundle\OAuth2ServerBundle\Model;

/**
 * Description of Authorization
 */
class Authorization
{

    /**
     * @var bool
     */
    protected $accepted;

    /**
     * @var string
     */
    protected $client_id;

    /**
     * @var string
     */
    protected $response_type;

    /**
     * @var string
     */
    protected $redirect_uri;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $scope;

    /**
     * 
     * @return type
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * 
     * @return type
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * 
     * @return type
     */
    public function getResponseType()
    {
        return $this->response_type;
    }

    /**
     * 
     * @return type
     */
    public function getRedirectUri()
    {
        return $this->redirect_uri;
    }

    /**
     * 
     * @return type
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * 
     * @return type
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * 
     * @param type $accepted
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;
        return $this;
    }

    /**
     * 
     * @param type $client_id
     * @return \Zamat\Bundle\OAuth2ServerBundle\Model\Authorization
     */
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
        return $this;
    }

    /**
     * 
     * @param type $response_type
     * @return \Zamat\Bundle\OAuth2ServerBundle\Model\Authorization
     */
    public function setResponseType($response_type)
    {
        $this->response_type = $response_type;
        return $this;
    }

    /**
     * 
     * @param type $redirect_uri
     * @return \Zamat\Bundle\OAuth2ServerBundle\Model\Authorization
     */
    public function setRedirectUri($redirect_uri)
    {
        $this->redirect_uri = $redirect_uri;
        return $this;
    }

    /**
     * 
     * @param type $state
     * @return \Zamat\Bundle\OAuth2ServerBundle\Model\Authorization
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * 
     * @param type $scope
     * @return \Zamat\Bundle\OAuth2ServerBundle\Model\Authorization
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
        return $this;
    }

    /**
     * 
     * @param array $query
     * @return \Zamat\Bundle\OAuth2ServerBundle\Model\Authorization
     */
    public function bind(array $query = array())
    {
        foreach ($query as $key => $value) {
            $this->{$key} = $value;
        }
        return $this;
    }

}
