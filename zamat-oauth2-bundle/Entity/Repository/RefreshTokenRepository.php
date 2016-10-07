<?php

namespace Zamat\Bundle\OAuth2Bundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;
use Zamat\OAuth2\Provider\RefreshTokenProviderInterface;
use Zamat\OAuth2\RefreshToken;

use Zamat\Bundle\OAuth2Bundle\Entity\RefreshToken as Entity;

/**
 * Description of RefreshTokenRepository
 * @author mateusz.zawada
 */
class RefreshTokenRepository extends EntityRepository implements RefreshTokenProviderInterface
{
    /**
     * 
     * @param RefreshToken $refreshToken
     * @return RefreshToken
     */
    public function save(RefreshToken $refreshToken)
    {
        $entity = new Entity();
        $entity->setClient($refreshToken->getClient());
        $entity->setExpires($refreshToken->getExpires());
        $entity->setScope($refreshToken->getScope());
        $entity->setToken($refreshToken->getToken());
        $entity->setUserId($refreshToken->getUserId());
        
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        
        
        return $refreshToken;
    }
    
    public function remove($token)
    {
        
        return $token;
    }
    
  
    
}