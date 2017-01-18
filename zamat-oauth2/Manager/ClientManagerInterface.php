<?php

namespace Zamat\OAuth2\Manager;

use Zamat\OAuth2\Provider\ClientProviderInterface;
use Zamat\OAuth2\Provider\ScopeProviderInterface;

interface ClientManagerInterface
{
    public function getClientProvider();
    public function setClientProvider(ClientProviderInterface $clientProvider);
    
    public function getScopeProvider();
    public function setScopeProvider(ScopeProviderInterface $scopeProvider);
    
    public function __construct(ClientProviderInterface $clientProvider, ScopeProviderInterface $scopeProvider);

    public function createClient($identifier, array $redirect_uris = array(), array $grant_types = array(), array $scopes = array());
    public function getClient($id);

}
