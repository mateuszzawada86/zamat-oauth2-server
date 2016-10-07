<?php

namespace Zamat\Bundle\OAuth2Bundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;
use Zamat\OAuth2\Provider\AuthorizationCodeProviderInterface;
use Zamat\OAuth2\AuthorizationCode;

use Zamat\Bundle\OAuth2Bundle\Entity\AuthorizationCode as Entity;

/**
 * Description of AuthorizationCodeRepository
 * @author mateusz.zawada
 */
class AuthorizationCodeRepository extends EntityRepository implements AuthorizationCodeProviderInterface
{
    
    /**
     * 
     * @param AuthorizationCode $accessToken
     * @return AuthorizationCode
     */
    public function save(AuthorizationCode $accessToken)
    {
                      
        $entity = new Entity();
        
        $entity->setClient($accessToken->getClient());
        $entity->setCode($accessToken->getCode());
        $entity->setExpires($accessToken->getExpires());
        $entity->setRedirectUri($accessToken->getRedirectUri());
        $entity->setScope($accessToken->getScope());
        $entity->setUserId($accessToken->getUserId());
        
        
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        
        
        return $accessToken;
    }
    
    /**
     * 
     * @param type $code
     */
    public function findCode($code)
    {
        return $this->findOneBy(array('code'=>$code));
    }
    
    /**
     * 
     * @param type $code
     * @return type
     */
    public function remove($code)
    {
        return $code;
    }
     
}