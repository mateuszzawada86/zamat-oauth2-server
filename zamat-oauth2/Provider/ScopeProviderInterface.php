<?php
namespace Zamat\OAuth2\Provider;
use Zamat\OAuth2\Scope;

/**
 * Description of ScopeProviderInterface
 * @author mateusz.zawada
 */
interface ScopeProviderInterface
{
    public function findScope($scope);
    public function save(Scope $scope);
    public function findScopesByScopes($scopes);

}
