<?php

namespace Zamat\OAuth2\Server;

use OAuth2\Server;

use OAuth2\Storage\ClientCredentialsInterface;
use OAuth2\Storage\AccessTokenInterface;
use OAuth2\Storage\AuthorizationCodeInterface;
use OAuth2\Storage\UserCredentialsInterface;
use OAuth2\Storage\RefreshTokenInterface;
use OAuth2\Storage\ScopeInterface;
use OAuth2\Storage\PublicKeyInterface;

use OAuth2\TokenType\TokenTypeInterface;

class OAuth2 extends Server
{
    /**
     * 
     * @param ClientCredentialsInterface $credentials
     * @param AccessTokenInterface $accessToken
     * @param AuthorizationCodeInterface $authorizationCode
     * @param UserCredentialsInterface $userCredential
     * @param RefreshTokenInterface $refreshToken
     * @param ScopeInterface $scope
     * @param PublicKeyInterface $publicKey
     * @param array $config
     * @param array $grantTypes
     * @param array $responseTypes
     * @param \OAuth2\TokenType\TokenTypeInterface $tokenType
     * @param \OAuth2\ScopeInterface $scopeUtil
     * @param \OAuth2\ClientAssertionType\ClientAssertionTypeInterface $clientAssertionType
     */
    public function __construct(
            
            ClientCredentialsInterface $credentials = null, 
            AccessTokenInterface $accessToken = null, 
            AuthorizationCodeInterface $authorizationCode = null, 
            UserCredentialsInterface $userCredential = null, 
            RefreshTokenInterface $refreshToken = null, 
            ScopeInterface $scope = null, 
            PublicKeyInterface $publicKey = null, 
            array $config = array(), array $grantTypes = array(), array $responseTypes = array(), TokenTypeInterface $tokenType = null, \OAuth2\ScopeInterface $scopeUtil = null, \OAuth2\ClientAssertionType\ClientAssertionTypeInterface $clientAssertionType = null)
    {
                
        parent::__construct(array_filter(array($credentials, $accessToken, $authorizationCode, $userCredential, $refreshToken,$scope,$publicKey)), $config, $grantTypes, $responseTypes, $tokenType, $scopeUtil, $clientAssertionType);
    }

}