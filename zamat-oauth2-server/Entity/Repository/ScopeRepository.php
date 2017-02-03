<?php

namespace Zamat\Bundle\OAuth2ServerBundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;
use Zamat\OAuth2\Provider\ScopeProviderInterface;
use Zamat\OAuth2\Scope;
use Zamat\Bundle\OAuth2ServerBundle\Entity\Scope as ScopeEntity;

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
        
        $entity = new ScopeEntity();
        $entity->setScope($scope->getScope());
        $entity->setDescription($scope->getDescription());
        
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        
        return $scope;
    }
       
    /**
     * 
     * @param type $id
     * @param type $lockMode
     * @param type $lockVersion
     * @return type
     */
    public function findScope($scope)
    {
        return $this->findOneBy(array('scope' => $scope));
    }
       
    /**
     * 
     * @param type $id
     * @param type $lockMode
     * @param type $lockVersion
     * @return type
     */
    public function findScopeByScope($scope)
    {
        return $this->findOneBy(array('scope' => $scope));
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