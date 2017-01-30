<?php

namespace Zamat\OAuth2\Storage;

use OAuth2\Storage\ScopeInterface;

use Zamat\OAuth2\Provider\ClientProviderInterface;
use Zamat\OAuth2\Provider\ScopeProviderInterface;

class ScopeStorage implements ScopeInterface
{

    /**
     *
     * @var ClientProviderInterface 
     */
    protected $clientProvider;
      
    /**
     *
     * @var ScopeProviderInterface 
     */
    protected $scopeProvider;
      
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
    public function getScopeProvider()
    {
        return $this->scopeProvider;
    }

    /**
     * 
     * @param ScopeProviderInterface $scopeProvider
     * @return \Zamat\OAuth2\Storage\ScopeStorage
     */
    public function setScopeProvider(ScopeProviderInterface $scopeProvider)
    {
        $this->scopeProvider = $scopeProvider;
        return $this;
    }

        
    /**
     * 
     * @param ClientProviderInterface $clientProvider
     * @param ScopeProviderInterface $scopeProvider
     */
    public function __construct(ClientProviderInterface $clientProvider, ScopeProviderInterface $scopeProvider = null)
    {
        $this->clientProvider = $clientProvider;
        $this->scopeProvider = $scopeProvider;
    }

    /**
     * Check if the provided scope exists.
     * @param $scope
     * A space-separated string of scopes.
     * @param $client_id
     * The requesting client.
     * @return
     * TRUE if it exists, FALSE otherwise.
     */
    public function scopeExists($scope, $client_id = null)
    {
        
        $scopes = explode(' ', $scope);
        if ($client_id) {
            $client = $this->getClientProvider()->find($client_id);
            if (!$client) {
                return false;
            }
            $valid_scopes = $client->getScopes();
            foreach ($scopes as $scope) {
                if (!in_array($scope, $valid_scopes)) {
                    return false;
                }
            }
            return true;
        }

        $valid_scopes = $this->scopeProvider->findScopesByScopes($scopes);
        return count($valid_scopes) == count($scopes);
    }

    /**
     * The default scope to use in the event the client
     * does not request one. By returning "false", a
     * request_error is returned by the server to force a
     * scope request by the client. By returning "null",
     * opt out of requiring scopes
     *
     * @return
     * string representation of default scope, null if
     * scopes are not defined, or false to force scope
     * request by the client
     *
     * ex:
     *     'default'
     * ex:
     *     null
     */
    public function getDefaultScope($client_id = null)
    {
        return false;
    }

    /**
     * Gets the description of a given scope key, if
     * available, otherwise the key is returned.
     *
     * @return
     * string description of the scope key.
     */
    public function getDescriptionForScope($scope)
    {
        $scopeObject = $this->scopeProvider->findScopeByScope($scope);
        if (!$scopeObject) {
            return $scope;
        }
        return $scopeObject->getDescription(); 
              
    }
}
