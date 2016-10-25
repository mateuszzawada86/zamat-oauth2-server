<?php
namespace Zamat\OAuth2\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

use Zamat\OAuth2\Security\User\OAuth2User;
use Zamat\OAuth2\Client\OAuthClient;

class OAuth2UserProvider implements UserProviderInterface
{
    

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
        
        try {
                        
            $client  = new OAuthClient();
            $userData = $client->getUserInformation("http://prezentacja.pl/app_dev.php/oauth/v2/verify", $accessToken);   
        }
        catch(\Exception $e)
        {
            throw new UsernameNotFoundException(sprintf('User for Access Token "%s" does not exist or is invalid.', $accessToken));
        }
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