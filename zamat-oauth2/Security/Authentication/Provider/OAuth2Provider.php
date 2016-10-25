<?php

namespace Zamat\OAuth2\Security\Authentication\Provider;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use Zamat\OAuth2\Security\Authentication\Token\OAuth2Token;

class OAuth2Provider implements AuthenticationProviderInterface
{
    
    /**
     *
     * @var type 
     */
    private $userProvider;

    /**
     * 
     * @param UserProviderInterface $userProvider
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
            
            # oauth /me page response
            
            
            $token->setAuthenticated(true);
            $token->setUser('admin');
            

            return $token;
        }
        catch (\Exception $e)
        {
            throw new AuthenticationException('The OAuth2 Access Token is invalid.');
        }
        throw new AuthenticationException('OAuth2 authentication failed.');
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

