<?php

namespace Zamat\OAuth2\Storage;

use OAuth2\Storage\AuthorizationCodeInterface;

use Zamat\OAuth2\Provider\ClientProviderInterface;
use Zamat\OAuth2\Provider\UserProviderInterface;
use Zamat\OAuth2\Provider\AuthorizationCodeProviderInterface;
use Zamat\OAuth2\AuthorizationCode;

class AuthorizationCodeStorage implements AuthorizationCodeInterface
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
     * @var AuthorizationCodeProviderInterface 
     */
    protected $authCodeProvider;

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
     * @return type
     */
    public function getAuthCodeProvider()
    {
        return $this->authCodeProvider;
    }

    /**
     * 
     * @param AuthorizationCodeProviderInterface $authCodeProvider
     * @return \Zamat\OAuth2\Storage\AuthorizationCodeStorage
     */
    public function setAuthCodeProvider(AuthorizationCodeProviderInterface $authCodeProvider)
    {
        $this->authCodeProvider = $authCodeProvider;
        return $this;
    }

    /**
     * 
     * @param ClientProviderInterface $clientProvider
     * @param AuthorizationCodeProviderInterface $authCodeProvider
     */
    public function __construct(ClientProviderInterface $clientProvider,UserProviderInterface $userProvider, AuthorizationCodeProviderInterface $authCodeProvider)
    {
        $this->clientProvider = $clientProvider;
        $this->userProvider = $userProvider;
        $this->authCodeProvider = $authCodeProvider;
    }

    /**
     * Fetch authorization code data (probably the most common grant type).
     *
     * Retrieve the stored data for the given authorization code.
     *
     * Required for OAuth2::GRANT_TYPE_AUTH_CODE.
     *
     * @param $code
     * Authorization code to be check with.
     *
     * @return
     * An associative array as below, and NULL if the code is invalid
     * @code
     * return array(
     *     "client_id"    => CLIENT_ID,      // REQUIRED Stored client identifier
     *     "user_id"      => USER_ID,        // REQUIRED Stored user identifier
     *     "expires"      => EXPIRES,        // REQUIRED Stored expiration in unix timestamp
     *     "redirect_uri" => REDIRECT_URI,   // REQUIRED Stored redirect URI
     *     "scope"        => SCOPE,          // OPTIONAL Stored scope values in space-separated string
     * );
     * @endcode
     *
     * @see http://tools.ietf.org/html/rfc6749#section-4.1
     *
     * @ingroup oauth2_section_4
     */
    public function getAuthorizationCode($code)
    {
        $authCode = $this->getAuthCodeProvider($code)->findCode($code);
        if (!$authCode) {
            return null;
        }

        return array(
            'client_id' => $authCode->getClient()->getClientId(),
            'user_id' => $authCode->getUser(),
            'expires' => $authCode->getExpires()->getTimestamp(),
            'redirect_uri' => implode(' ', $authCode->getRedirectUri()),
            'scope' => $authCode->getScope()
        );
    }

    /**
     * Take the provided authorization code values and store them somewhere.
     *
     * This function should be the storage counterpart to getAuthCode().
     *
     * If storage fails for some reason, we're not currently checking for
     * any sort of success/failure, so you should bail out of the script
     * and provide a descriptive fail message.
     *
     * Required for OAuth2::GRANT_TYPE_AUTH_CODE.
     *
     * @param $code
     * Authorization code to be stored.
     * @param $client_id
     * Client identifier to be stored.
     * @param $user_id
     * User identifier to be stored.
     * @param string $redirect_uri
     *                             Redirect URI(s) to be stored in a space-separated string.
     * @param int    $expires
     *                             Expiration to be stored as a Unix timestamp.
     * @param string $scope
     *                             (optional) Scopes to be stored in space-separated string.
     *
     * @ingroup oauth2_section_4
     */
    public function setAuthorizationCode($code, $client_id, $user_id, $redirect_uri, $expires, $scope = null)
    {
        $client = $this->getClientProvider()->find($client_id);
        $userObject = $this->getUserProvider()->findOneByUsername($user_id);

        if (!$client) {
            throw new \Exception('Unknown client identifier');
        }

        $authorizationCode = new AuthorizationCode();
        $authorizationCode->setCode($code);
        $authorizationCode->setClient($client);
        $authorizationCode->setUser($userObject);
        $authorizationCode->setRedirectUri($redirect_uri);
        $authorizationCode->setExpires($expires);
        $authorizationCode->setScope($scope);

        $this->getAuthCodeProvider()->save($authorizationCode);
    }

    /**
     * once an Authorization Code is used, it must be exipired
     *
     * @see http://tools.ietf.org/html/rfc6749#section-4.1.2
     *
     *    The client MUST NOT use the authorization code
     *    more than once.  If an authorization code is used more than
     *    once, the authorization server MUST deny the request and SHOULD
     *    revoke (when possible) all tokens previously issued based on
     *    that authorization code
     *
     */
    public function expireAuthorizationCode($code)
    {
        $authorizationCode = $this->getAuthCodeProvider()->find($code);
        if ($authorizationCode) {
            $this->getAuthCodeProvider()->remove($authorizationCode);
        }
    }

}
