<?php

namespace Zamat\Bundle\OAuth2Bundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;
use Zamat\OAuth2\Provider\AuthorizationCodeProviderInterface;
use Zamat\OAuth2\AuthorizationCode;

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
        return $accessToken;
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