<?php

namespace Zamat\OAuth2\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

use Zamat\OAuth2\Client\OAuthClientInterface;
use Zamat\OAuth2\Security\User\OAuth2User;

class OAuth2UserProvider implements UserProviderInterface
{

    /**
     *
     * @var OAuthClientInterface 
     */
    private $client;

    /**
     * 
     * @param OAuthClientInterface $client
     */
    public function __construct(OAuthClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * 
     * @return OAuthClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * 
     * @param OAuthClientInterface $client
     * @return \Zamat\OAuth2\Security\User\OAuth2UserProvider
     */
    public function setClient(OAuthClientInterface $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * 
     * @param type $username
     * @return type
     */
    public function loadUserByUsername($username)
    {
        return $this->loadUserByAccessToken($username);
    }

    /**
     * 
     * @param type $accessToken
     * @return OAuth2User
     * @throws UsernameNotFoundException
     */
    public function loadUserByAccessToken($accessToken)
    {
        
        $userData = $this->getClient()->getUserInformation($accessToken);
        if ($userData) {
            $userObject = new OAuth2User($accessToken, $userData['client_id'], $userData['user_id'], explode(' ', $userData['scope']));
            return $userObject;
        }
        throw new UsernameNotFoundException(sprintf('User for Access Token "%s" does not exist or is invalid.', $accessToken));

    }

    /**
     * 
     * @param UserInterface $user
     * @return type
     * @throws UnsupportedUserException
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof OAuth2User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }
        return $this->loadUserByAccessToken($user->getAccessToken());
    }

    /**
     * 
     * @param type $class
     * @return type
     */
    public function supportsClass($class)
    {
        return $class === OAuth2User::class;
    }

}
