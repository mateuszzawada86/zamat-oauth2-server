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
     * @var UserProviderInterface 
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

            if (!$this->supports($token)) {
                return;
            }
            $user = $this->userProvider->loadUserByAccessToken($token->getAccessToken());
                                
            if (!$user) {
                throw new AuthenticationException('User object is not valid');
            }

            $oauth2Token = new OAuth2Token($user->getRoles());
            $oauth2Token->setAccessToken($user->getAccessToken());
            $oauth2Token->setRefreshToken($token->getRefreshToken());
            $oauth2Token->setRawToken(json_encode($token));
            $oauth2Token->setExpires($token->getExpires());
            $oauth2Token->setUser($user);


            return $oauth2Token;
        }
        catch (\Exception $exception) {
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
