<?php

namespace Zamat\OAuth2\Storage;

use OAuth2\Storage\AccessTokenInterface;

use Zamat\OAuth2\Provider\ClientProviderInterface;
use Zamat\OAuth2\Provider\AccessTokenProviderInterface;
use Zamat\OAuth2\Provider\UserProviderInterface;
use Zamat\OAuth2\AccessToken;
use Zamat\OAuth2\UserInterface;

class AccessTokenStorage implements AccessTokenInterface
{

    /**
     *
     * @var ClientProviderInterface 
     */
    protected $clientProvider;
    
    /**
     *
     * @var UserProviderInterface 
     */
    protected $userProvider;   
    
    /**
     *
     * @var AccessTokenProviderInterface 
     */
    protected $accessTokenProvider;

    /**
     * 
     * @return type
     */
    public function getClientProvider()
    {
        return $this->clientProvider;
    }

    /**
     * 
     * @param type $clientProvider
     * @return \Zamat\OAuth2\Storage\ClientCredentialsStorage
     */
    public function setClientProvider(ClientProviderInterface $clientProvider)
    {
        $this->clientProvider = $clientProvider;
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getAccessTokenProvider()
    {
        return $this->accessTokenProvider;
    }

    /**
     * 
     * @param AccessTokenProviderInterface $accessTokenProvider
     * @return \Zamat\OAuth2\Storage\AccessTokenStorage
     */
    public function setAccessTokenProvider(AccessTokenProviderInterface $accessTokenProvider)
    {
        $this->accessTokenProvider = $accessTokenProvider;
        return $this;
    }
    
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
     * @param UserProviderInterface $userProvider
     * @return \Zamat\OAuth2\Storage\AccessTokenStorage
     */
    public function setUserProvider(UserProviderInterface $userProvider)
    {
        $this->userProvider = $userProvider;
        return $this;
    }

    
    /**
     * 
     * @param ClientProviderInterface $clientProvider
     * @param AccessTokenProviderInterface $accessTokenProvider
     */
    public function __construct(ClientProviderInterface $clientProvider,UserProviderInterface $userProvider, AccessTokenProviderInterface $accessTokenProvider)
    {
        $this->clientProvider = $clientProvider;
        $this->userProvider = $userProvider;
        $this->accessTokenProvider = $accessTokenProvider;
    }

    /**
     * Look up the supplied oauth_token from storage.
     *
     * We need to retrieve access token data as we create and verify tokens.
     *
     * @param $oauth_token
     * oauth_token to be check with.
     *
     * @return
     * An associative array as below, and return NULL if the supplied oauth_token
     * is invalid:
     * - client_id: Stored client identifier.
     * - expires: Stored expiration in unix timestamp.
     * - scope: (optional) Stored scope values in space-separated string.
     *
     * @ingroup oauth2_section_7
     */
    public function getAccessToken($oauth_token)
    {
        $accessToken = $this->getAccessTokenProvider()->find($oauth_token);

        if (!$accessToken) {
            return null;
        }

        $client = $accessToken->getClient();      

        return array(
            'client_id' => $client->getClientId(),
            'user_id'   => $accessToken->getUser()->getUsername(),
            'expires'   => $accessToken->getExpires()->getTimestamp(),
            'scope'     => $accessToken->getScope()
        );
    }

    /**
     * Store the supplied access token values to storage.
     *
     * We need to store access token data as we create and verify tokens.
     *
     * @param $oauth_token
     * oauth_token to be stored.
     * @param $client_id
     * Client identifier to be stored.
     * @param $user_id
     * User identifier to be stored.
     * @param int    $expires
     *                        Expiration to be stored as a Unix timestamp.
     * @param string $scope
     *                        (optional) Scopes to be stored in space-separated string.
     *
     * @ingroup oauth2_section_4
     */
    public function setAccessToken($oauth_token, $client_id, $user_id, $expires, $scope = null)
    {
                     
        // Get Client Entity
        $client = $this->getClientProvider()->find($client_id);
        
        if($user_id instanceof UserInterface) {
           $userObject = $this->getUserProvider()->findOneByUsername($user_id->getUsername()); 
        } else {
          $userObject = $this->getUserProvider()->findOneByUsername($user_id);   
        }
         
        if (!$client) {
            return null;
        }
            
        // Create Access Token
        $accessToken = new AccessToken();
        $accessToken->setToken($oauth_token);
        $accessToken->setClient($client);
        $accessToken->setUser($userObject ? $userObject : null);
        $accessToken->setExpires($expires);
        $accessToken->setScope($scope);
        
        
        $this->getAccessTokenProvider()->save($accessToken);
    }
    
    /**
     * 
     * @param type $token
     * @return type
     */
    public function verifyAccessToken($token)
    {
        return $this->getAccessTokenProvider()->find($token);
        
    }

}
