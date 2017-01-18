<?php

namespace Zamat\OAuth2\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

class OAuth2User implements UserInterface, EquatableInterface
{

    /**
     *
     * @var type 
     */
    private $client_id;
    /**
     *
     * @var type 
     */
    private $user_id;
    /**
     *
     * @var type 
     */
    private $scopes;
    /**
     *
     * @var type 
     */
    private $access_token;

    /**
     * 
     * @param type $access_token
     * @param type $client_id
     * @param type $user_id
     * @param array $scopes
     */
    public function __construct($access_token, $client_id, $user_id = null, array $scopes = array())
    {
        $this->user_id = $user_id;
        $this->client_id = $client_id;
        $this->scopes = $scopes;
        $this->access_token = $access_token;
    }

    /**
     * 
     * @return array
     */
    public function getRoles()
    {
        $roles = array();
        foreach ($this->scopes as $scope) {
            $roles[] = 'ROLE_' . strtoupper($scope);
        }
        return $roles;
    }

    /**
     * 
     * @return type
     */
    public function getPassword()
    {
        return null;
    }

    /**
     * 
     * @return type
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * 
     * @return type
     */
    public function getUsername()
    {
        if (!empty($this->user_id)) {
            return $this->user_id;
        }
        return $this->client_id;
    }

    /**
     * 
     * @return type
     */
    public function getUserId()
    {
        return $this->user_id;
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
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * 
     * @return boolean
     */
    public function isUser()
    {
        if (!empty($this->user_id)) {
            return true;
        }
        return false;
    }

    /**
     * 
     * @return type
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    public function eraseCredentials()
    {
        
    }

    /**
     * 
     * @param UserInterface $user
     * @return boolean
     */
    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof OAuth2User) {
            return false;
        }
        if ($this->access_token !== $user->getAccessToken()) {
            return false;
        }
        if ($this->client_id !== $user->getClientId()) {
            return false;
        }
        if ($this->user_id !== $user->getUserId()) {
            return false;
        }
        return true;
    }

}
