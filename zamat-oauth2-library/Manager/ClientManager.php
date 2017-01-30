<?php

namespace Zamat\OAuth2\Manager;

use Zamat\OAuth2\Provider\ClientProviderInterface;
use Zamat\OAuth2\Provider\ScopeProviderInterface;

use Zamat\OAuth2\Manager\ScopeManagerInterface;
use Zamat\OAuth2\Exception\ScopeNotFoundException;
use Zamat\OAuth2\Client;

class ClientManager implements ClientManagerInterface
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
     * @param ClientProviderInterface $clientProvider
     * @return \Zamat\OAuth2\Manager\ClientManager
     */
    public function setClientProvider(ClientProviderInterface $clientProvider)
    {
        $this->clientProvider = $clientProvider;
        return $this;
    }

    /**
     * 
     * @return ScopeProviderInterface
     */
    public function getScopeProvider()
    {
        return $this->scopeProvider;
    }

    /**
     * 
     * @param ScopeProviderInterface $scopeProvider
     * @return \Zamat\OAuth2\Manager\ScopeManager
     */
    public function setScopeProvider(ScopeProviderInterface $scopeProvider)
    {
        $this->scopeProvider = $scopeProvider;
        return $this;
    }

    /**
     * 
     * @param ClientProviderInterface $clientProvider
     * @param ScopeManagerInterface $scopeManager
     */
    public function __construct(ClientProviderInterface $clientProvider, ScopeManagerInterface $scopeManager)
    {
        $this->clientProvider = $clientProvider;
        $this->scopeProvider = $scopeManager;
    }

    /**
     * Creates a new client
     *
     * @param string $identifier
     *
     * @param array $redirect_uris
     *
     * @param array $grant_types
     *
     * @param array $scopes
     *
     * @return Client
     */
    public function createClient($identifier, array $redirect_uris = array(), array $grant_types = array(), array $scopes = array())
    {
        $client = new Client();
        
        $client->setClientId($identifier);
        $client->setClientSecret($this->generateSecret());
        $client->setRedirectUri($redirect_uris);
        $client->setGrantTypes($grant_types);

        foreach ($scopes as $scope) {
            $scopeObject = $this->scopeProvider->findScopeByScope($scope);
            if (!$scopeObject) {
                throw new ScopeNotFoundException();
            }
        }
        $client->setScopes($scopes);
        
        $this->clientProvider->save($client);
        return $client;
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function getClient($id)
    {
        return $this->clientProvider->find($id);
    }

    /**
     * Creates a secret for a client
     *
     * @return A secret
     */
    protected function generateSecret()
    {
        return base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }
}
