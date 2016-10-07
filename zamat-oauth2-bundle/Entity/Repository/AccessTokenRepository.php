<?php

namespace Zamat\Bundle\OAuth2Bundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;

use Zamat\Bundle\OAuth2Bundle\Entity\AccessToken as Entity;

use Zamat\OAuth2\Provider\AccessTokenProviderInterface;
use Zamat\OAuth2\AccessToken;

/**
 * Description of AccessTokenRepository
 * @author mateusz.zawada
 */
class AccessTokenRepository extends EntityRepository implements AccessTokenProviderInterface
{
    /**
     * 
     * @param AccessToken $accessToken
     * @return \Zamat\Bundle\OAuth2Bundle\Entity\Repository\AccessTokenRepository
     */
    public function save(AccessToken $accessToken)
    {
        
        $entity = new Entity();
        $entity->setClient($accessToken->getClient());
        $entity->setExpires($accessToken->getExpires());
        $entity->setScope($accessToken->getScope());
        $entity->setToken($accessToken->getToken());
        $entity->setUserId($accessToken->getUserId());
        
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        
        return $accessToken;
    }
    
  
    
}