<?php

namespace Zamat\Bundle\OAuth2ServerBundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;

use Zamat\OAuth2\Provider\AuthorizationCodeProviderInterface;
use Zamat\OAuth2\AuthorizationCode;
use Zamat\Bundle\OAuth2ServerBundle\Entity\AuthorizationCode as Entity;

/**
 * Description of AuthorizationCodeRepository
 * @author mateusz.zawada
 */
class AuthorizationCodeRepository extends EntityRepository implements AuthorizationCodeProviderInterface
{
    
    /**
     * 
     * @param AuthorizationCode $authorizationCode
     * @return AuthorizationCode
     */
    public function save(AuthorizationCode $authorizationCode)
    {
                                   
        $entity = new Entity();

        $entity->setClient($authorizationCode->getClient());
        $entity->setCode($authorizationCode->getCode());
        $entity->setExpires($authorizationCode->getExpires());
        $entity->setRedirectUri($authorizationCode->getRedirectUri());
        $entity->setScope($authorizationCode->getScope());
        $entity->setUser($authorizationCode->getUser());
        
        
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        
        
        return $authorizationCode;
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