<?php

namespace Zamat\Bundle\OAuth2Bundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;
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
        return $accessToken;
    }
    
  
    
}