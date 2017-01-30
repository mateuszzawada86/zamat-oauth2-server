<?php

namespace Zamat\OAuth2\Storage;

use OAuth2\Storage\UserCredentialsInterface;

use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;


class UserCredentialsStorage  implements UserCredentialsInterface
{
    
    /**
     *
     * @var UserProviderInterface 
     */
    protected $userProvider;
    
    /**
     *
     * @var EncoderFactoryInterface 
     */
    protected $encoderFactory;
        
    /**
     * 
     * @return type
     */
    public function getUserProvider()
    {
        return $this->userProvider;
    }

    /**
     * 
     * @return type
     */
    public function getEncoderFactory()
    {
        return $this->encoderFactory;
    }

    /**
     * 
     * @param UserProviderInterface $userProvider
     * @return \Zamat\OAuth2\Storage\UserCredentialsStorage
     */
    public function setUserProvider(UserProviderInterface $userProvider)
    {
        $this->userProvider = $userProvider;
        return $this;
    }

    /**
     * 
     * @param EncoderFactoryInterface $encoderFactory
     * @return \Zamat\OAuth2\Storage\UserCredentialsStorage
     */
    public function setEncoderFactory(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
        return $this;
    }

    /**
     * 
     * @param UserProviderInterface $userProvider
     * @param EncoderFactoryInterface $encoderFactory
     */
    public function __construct(UserProviderInterface $userProvider, EncoderFactoryInterface $encoderFactory)
    {
        $this->userProvider = $userProvider;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * Grant access tokens for basic user credentials.
     *
     * Check the supplied username and password for validity.
     *
     * You can also use the $client_id param to do any checks required based
     * on a client, if you need that.
     *
     * Required for OAuth2::GRANT_TYPE_USER_CREDENTIALS.
     *
     * @param $username
     * Username to be check with.
     * @param $password
     * Password to be check with.
     *
     * @return
     * TRUE if the username and password are valid, and FALSE if it isn't.
     * Moreover, if the username and password are valid, and you want to
     *
     * @see http://tools.ietf.org/html/rfc6749#section-4.3
     *
     * @ingroup oauth2_section_4
     */
    public function checkUserCredentials($username, $password)
    {
        try {
            $user = $this->userProvider->loadUserByUsername($username);                        
        } catch (UsernameNotFoundException $e) {
            return false;
        }
        
        if ($user instanceof AdvancedUserInterface) {
            if ($user->isAccountNonExpired() === false) {
                return false;
            }
            if ($user->isCredentialsNonExpired() === false || $user->isEnabled() === false || $user->isAccountNonLocked() === false) {
                return false;
            }
        } 
        
        if ($this->encoderFactory->getEncoder($user)->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
            return true;
        }
        return false;
    }

    /**
     * @return
     * ARRAY the associated "user_id" and optional "scope" values
     * This function MUST return FALSE if the requested user does not exist or is
     * invalid. "scope" is a space-separated list of restricted scopes.
     * @code
     * return array(
     *     "user_id"  => USER_ID,    // REQUIRED user_id to be stored with the authorization code or access token
     *     "scope"    => SCOPE       // OPTIONAL space-separated list of restricted scopes
     * );
     * @endcode
     */
    public function getUserDetails($username)
    {
        try {           
            return $this->userProvider->loadUserWithScopes($username);             
        } catch (UsernameNotFoundException $e) {
            return false;
        }
                
    }
}
