<?php

namespace Zamat\OAuth2\Manager;

use Zamat\OAuth2\Provider\ClientProviderInterface;
use Zamat\OAuth2\Manager\ScopeManagerInterface;
use OAuth2\Exception\ScopeNotFoundException;

use Zamat\OAuth2\Client;


class ClientManager
{
    /**
     *
     * @var ClientProviderInterface 
     */
    protected $clientProvider;
    
    /**
     *
     * @var ScopeManagerInterface 
     */
    protected $scopeManager;
    
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
     * @return type
     */
    public function getScopeManager()
    {
        return $this->scopeManager;
    }

    /**
     * 
     * @param ScopeManagerInterface $scopeManager
     * @return \Zamat\OAuth2\Manager\ClientManager
     */
    public function setScopeManager(ScopeManagerInterface $scopeManager)
    {
        $this->scopeManager = $scopeManager;
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
        $this->scopeManager = $scopeManager;
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
            $scopeObject = $this->scopeManager->findScopeByScope($scope);
            if (!$scopeObject) {
                throw new ScopeNotFoundException();
            }
        }
        $client->setScopes($scopes);
        
        $this->clientProvider->save($client);
        return $client;
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
