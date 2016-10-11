<?php

namespace Zamat\OAuth2\Manager;

use Zamat\OAuth2\Scope;
use Zamat\OAuth2\Provider\ScopeProviderInterface;

class ScopeManager implements ScopeManagerInterface
{
   
    /**
     *
     * @var ScopeProviderInterface 
     */
    protected $scopeProvider;
    
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
     * @param ScopeProviderInterface $scopeProvider
     */
    public function __construct(ScopeProviderInterface $scopeProvider)
    {        
        $this->setScopeProvider($scopeProvider);
    }

    /**
     * Creates a new scope
     *
     * @param string $scope
     *
     * @param string $description
     *
     * @return Scope
     */
    public function createScope($scope, $description = null)
    {
        $scopeObject = new Scope();
        $scopeObject->setScope($scope);
        $scopeObject->setDescription($description);

        $this->scopeProvider->save($scopeObject);

        return $scopeObject;
    }

    /**
     * Find a single scope by the scope
     *
     * @param $scope
     * @return Scope
     */
    public function findScopeByScope($scope)
    {
        return $this->scopeProvider->findScope($scope);
    }

    /**
     * Find all the scopes by an array of scopes
     *
     * @param array $scopes
     * @return mixed|void
     */
    public function findScopesByScopes(array $scopes)
    {
        return $this->scopeProvider->findScopesByScopes($scopes);
    }
}
