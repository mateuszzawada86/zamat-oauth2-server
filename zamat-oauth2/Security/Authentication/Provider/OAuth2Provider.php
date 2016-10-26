<?php

namespace Zamat\OAuth2\Security\Authentication\Provider;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use Zamat\OAuth2\Client\OAuthClientInterface;
use Zamat\OAuth2\Security\Authentication\Token\OAuth2Token;

class OAuth2Provider implements AuthenticationProviderInterface
{
    
    /**
     *
     * @var UserProviderInterface 
     */
    private $userProvider;
    
    /**
     * 
     * @param UserProviderInterface $userProvider
     * @param OAuthClientInterface $client
     */
    public function __construct(UserProviderInterface $userProvider)
    {
        $this->userProvider = $userProvider;
    }
    
    /**
     * 
     * @param TokenInterface $token
     * @return OAuth2Token
     * @throws AuthenticationException
     */   
    public function authenticate(TokenInterface $token)
    {
        try {
            
            $token->setAuthenticated(true);
            $token->setUser('admin');
            
            return $token;
        }
        catch (\Exception $e)
        {
            throw new AuthenticationException('The OAuth2 Access Token is invalid.');
        }
    }
    
    /**
     * 
     * @param TokenInterface $token
     * @return type
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof OAuth2Token;
    }
}

