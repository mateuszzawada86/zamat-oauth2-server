<?php

namespace Zamat\OAuth2\Security\Authentication\Provider;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Zamat\OAuth2\Security\Authentication\Token\OAuth2Token;
use Zamat\OAuth2\Storage\AccessTokenStorage;

/**
 * OAuthProvider class.
 */
class OAuth2Provider implements AuthenticationProviderInterface
{

    /**
     * @var UserProviderInterface
     */
    protected $userProvider;

    /**
     * @var AccessTokenStorage
     */
    protected $accessTokenStorage;
    
    /**
     * @var UserCheckerInterface
     */
    protected $userChecker;

    /**
     * 
     * @param UserProviderInterface $userProvider
     * @param AccessTokenStorage $accessTokenStorage
     * @param UserCheckerInterface $userChecker
     */
    public function __construct(UserProviderInterface $userProvider = null, AccessTokenStorage $accessTokenStorage = null , UserCheckerInterface $userChecker = null)
    {
        $this->userProvider = $userProvider;
        $this->accessTokenStorage = $accessTokenStorage;
        $this->userChecker = $userChecker;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(TokenInterface $token)
    {
        if (!$this->supports($token)) {
            return;
        }

        try {

            $accessToken = $this->accessTokenStorage->verifyAccessToken($token->getToken());
            if(!$accessToken) {
                return;
            }
            $currentTime = new \DateTime();
            if ($accessToken->getExpires()->getTimestamp() < $currentTime->getTimestamp()) {
                throw new AuthenticationException('OAuth2 authentication failed. Token expired');
            }
            
            $token->setAuthenticated(true);      
            $token->setUser($accessToken->getUserId());
            var_dump($token);
            die();
            return $token;
        }
        catch (\Exception $e) {

            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof OAuth2Token;
    }

}
