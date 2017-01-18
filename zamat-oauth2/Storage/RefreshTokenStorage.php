<?php

namespace Zamat\OAuth2\Storage;

use OAuth2\Storage\RefreshTokenInterface;

use Zamat\OAuth2\Provider\RefreshTokenProviderInterface;
use Zamat\OAuth2\Provider\ClientProviderInterface;
use Zamat\OAuth2\Provider\UserProviderInterface;
use Zamat\OAuth2\RefreshToken;


class RefreshTokenStorage implements RefreshTokenInterface
{
    /**
     *
     * @var RefreshTokenProviderInterface 
     */
    protected $refreshTokenProvider;
    
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
     * @return type
     */
    public function getRefreshTokenProvider()
    {
        return $this->refreshTokenProvider;
    }

    /**
     * 
     * @param RefreshTokenProviderInterface $refreshTokenProvider
     * @return \Zamat\OAuth2\Storage\RefreshTokenStorage
     */
    public function setRefreshTokenProvider(RefreshTokenProviderInterface $refreshTokenProvider)
    {
        $this->refreshTokenProvider = $refreshTokenProvider;
        return $this;
    }
       
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
     * @param RefreshTokenProviderInterface $refreshTokenProvider
     * @param ClientProviderInterface $clientProvider
     * @param UserProviderInterface $userProvider
     */
    public function __construct(RefreshTokenProviderInterface $refreshTokenProvider,ClientProviderInterface $clientProvider,UserProviderInterface $userProvider)
    {
        $this->refreshTokenProvider = $refreshTokenProvider;
        $this->clientProvider = $clientProvider;
        $this->userProvider = $userProvider;
    }

    /**
     * Grant refresh access tokens.
     *
     * Retrieve the stored data for the given refresh token.
     *
     * Required for OAuth2::GRANT_TYPE_REFRESH_TOKEN.
     *
     * @param $refresh_token
     * Refresh token to be check with.
     *
     * @return
     * An associative array as below, and NULL if the refresh_token is
     * invalid:
     * - refresh_token: Stored refresh token identifier.
     * - client_id: Stored client identifier.
     * - user_id: Stored user identifier.
     * - expires: Stored expiration unix timestamp.
     * - scope: (optional) Stored scope values in space-separated string.
     *
     * @see http://tools.ietf.org/html/rfc6749#section-6
     *
     * @ingroup oauth2_section_6
     */
    public function getRefreshToken($refresh_token)
    {
        $refreshToken = $this->getRefreshTokenProvider()->find($refresh_token);
        if (!$refreshToken) {
            return null;
        }

        // Get Client
        $client = $refreshToken->getClient();

        return array(
            'refresh_token' => $refreshToken->getToken(),
            'client_id' => $client->getClientId(),
            'user_id' => $refreshToken->getUser()->getUsername(),
            'expires' => $refreshToken->getExpires()->getTimestamp(),
            'scope' => $refreshToken->getScope()
        );
    }

    /**
     * Take the provided refresh token values and store them somewhere.
     *
     * This function should be the storage counterpart to getRefreshToken().
     *
     * If storage fails for some reason, we're not currently checking for
     * any sort of success/failure, so you should bail out of the script
     * and provide a descriptive fail message.
     *
     * Required for OAuth2::GRANT_TYPE_REFRESH_TOKEN.
     *
     * @param $refresh_token
     * Refresh token to be stored.
     * @param $client_id
     * Client identifier to be stored.
     * @param $user_id
     * User identifier to be stored.
     * @param $expires
     * expires to be stored.
     * @param $scope
     * (optional) Scopes to be stored in space-separated string.
     *
     * @ingroup oauth2_section_6
     */
    public function setRefreshToken($refresh_token, $client_id, $user_id, $expires, $scope = null)
    {
        // Get Client Entity
        $client = $this->getClientProvider()->find($client_id);
        if (!$client) {
            return null;
        }
        $userObject = $this->getUserProvider()->findOneByUsername($user_id);
    

        // Create Refresh Token
        $refreshToken = new RefreshToken();
        $refreshToken->setToken($refresh_token);
        $refreshToken->setClient($client);
        $refreshToken->setUser($userObject ? $userObject : null);
        $refreshToken->setExpires($expires);
        $refreshToken->setScope($scope);

        $this->getRefreshTokenProvider()->save($refreshToken);
    }

    /**
     * Expire a used refresh token.
     *
     * This is not explicitly required in the spec, but is almost implied.
     * After granting a new refresh token, the old one is no longer useful and
     * so should be forcibly expired in the data store so it can't be used again.
     *
     * If storage fails for some reason, we're not currently checking for
     * any sort of success/failure, so you should bail out of the script
     * and provide a descriptive fail message.
     *
     * @param $refresh_token
     * Refresh token to be expirse.
     *
     * @ingroup oauth2_section_6
     */
    public function unsetRefreshToken($refresh_token)
    {
        $refreshToken = $this->getRefreshTokenProvider()->find($refresh_token);
        $this->getRefreshTokenProvider()->remove($refreshToken);
    }
}
