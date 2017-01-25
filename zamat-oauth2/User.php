<?php

namespace Zamat\OAuth2;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Zamat\OAuth2\UserInterface as OAuth2UserInterface;

/**
 * Description of User
 * @author mateusz.zawada
 */
class User implements AdvancedUserInterface, EquatableInterface, \Serializable,OAuth2UserInterface
{

    /**
     *
     * @var type 
     */
    protected $id;

    /**
     *
     * @var type 
     */
    protected $username;

    /**
     *
     * @var type 
     */
    protected $email;

    /**
     *
     * @var type 
     */
    protected $password;

    /**
     *
     * @var type 
     */
    protected $salt;

    /**
     *
     * @var type 
     */
    protected $roles;

    /**
     *
     * @var type 
     */
    protected $isActive;

    /**
     * 
     * @param type $username
     * @param type $password
     * @param type $salt
     * @param array $roles
     * @param type $isActive
     * @param type $email
     */
    public function __construct(
    $username = null, $password = null, $salt = null, array $roles = null, $isActive = true, $email = null
    )
    {
        $this->roles = $roles;
        $this->username = $username;
        $this->password = $password;
        $this->salt = $salt;
        $this->isActive = $isActive;
        $this->email = $email;
    }

    /**
     * 
     * @return type
     */
    public function getRoles()
    {
        return $this->roles ? $this->roles : array('ROLE_USER');
    }

    /**
     * 
     * @param type $id
     * @return \Zamat\Security\Component\Authentication\Provider\User\DefaultUser
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 
     * @return type
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * 
     * @return type
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * 
     * @return type
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * 
     * @return type
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * 
     * @return \Zamat\Bundle\SecurityBundle\User\DefaultUser\DefaultUser
     */
    public function eraseCredentials()
    {
        return $this;
    }

    /**
     * 
     * @param UserInterface $user
     * @return boolean
     * 
     */
    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof DefaultUser) {
            return false;
        }
        if ($this->password !== $user->getPassword()) {
            return false;
        }
        if ($this->salt !== $user->getSalt()) {
            return false;
        }
        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    /**
     * 
     * @return boolean
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * 
     * @return boolean
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * 
     * @return boolean
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * 
     * @return type
     */
    public function isEnabled()
    {
        return $this->isActive;
    }

    /**
     * 
     * @param type $username
     * @return \Zamat\Bundle\SecurityBundle\User\DefaultUser
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * 
     * @param type $email
     * @return \Zamat\Security\Component\Authentication\Provider\User\DefaultUser
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * 
     * @param type $password
     * @return \Zamat\Security\Component\Authentication\Provider\User\DefaultUser
     */
    public function setPassword($password)
    {

        $this->password = $password;
        return $this;
    }

    /**
     * 
     * @param type $status
     */
    public function setEnabled($status)
    {
        $this->isActive = $status;
        return $this;
    }

    /**
     * 
     * @param type $status
     */
    public function setEnabledStatus($status)
    {
        $this->isActive = $status;
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            $this->email,
        ));
    }

    /**
     * 
     * @param type $serialized
     */
    public function unserialize($serialized)
    {
        list (
                $this->id,
                $this->username,
                $this->password,
                $this->isActive,
                $this->email,
                ) = unserialize($serialized);
    }

    /**
     * 
     * @return type
     */
    public function __toString()
    {
        return (string) $this->getEmail();
    }

}
