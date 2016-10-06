<?php

namespace Zamat\Bundle\OAuth2Bundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;
use Zamat\OAuth2\Provider\ScopeProviderInterface;
use Zamat\OAuth2\Scope;

/**
 * Description of ScopeRepository
 * @author mateusz.zawada
 */
class ScopeRepository extends EntityRepository implements ScopeProviderInterface
{
    
    /**
     * 
     * @param Scope $scope
     * @return Scope
     */
    public function save(Scope $scope)
    {
        return $scope;
    }
    
    /**
     * 
     * @param type $scopes
     * @return type
     */
    public function findScopesByScopes($scopes = array())
    {
        return $this->createQueryBuilder('a')
                        ->where('a.scope in (?1)')
                        ->setParameter(1, implode(',', $scopes))
                        ->getQuery()->getResult();
    }

}