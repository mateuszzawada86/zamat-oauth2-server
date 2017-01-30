<?php

namespace Zamat\OAuth2\Manager;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

use Zamat\OAuth2\Provider\UserProviderInterface as OAuth2UserProviderInterface;

class UserManager implements UserManagerInterface
{
  
    /**
     *
     * @var OAuth2UserProviderInterface 
     */
    protected $userProvider;
       
    /**
     * 
     * @return OAuth2UserProviderInterface
     */
    public function getUserProvider()
    {
        return $this->userProvider;
    }

    /**
     * 
     * @param OAuth2UserProviderInterface $userProvider
     * @return \Zamat\OAuth2\Manager\UserManager
     */
    public function setUserProvider(OAuth2UserProviderInterface $userProvider)
    {
        $this->userProvider = $userProvider;
        return $this;
    }

    /**
     * 
     * @param type $userProvider
     */
    public function __construct(OAuth2UserProviderInterface $userProvider)
    {
        $this->userProvider = $userProvider;
    }
    
    /**
     * 
     * @param string $username
     * @return type
     */
    public function loadUserByUsername($username)
    {
        return $this->getUserProvider()->findOneByUsername($username);
    }
    
    /**
     * 
     * @param string $username
     * @return type
     */
    public function loadUserWithScopes($username)
    {
        return array(
            'user_id' => $this->loadUserByUsername($username)->getUsername(),
            'scope' => null
        );
    } 

    /**
     * 
     * @param UserInterface $user
     * @return type
     * @throws UnsupportedUserException
     */
    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * 
     * @param type $class
     * @return boolean
     */
    public function supportsClass($class)
    {
        return true;
    }   

 
}
