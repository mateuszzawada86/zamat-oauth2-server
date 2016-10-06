<?php

namespace Zamat\Bundle\OAuth2Bundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;
use Zamat\OAuth2\Provider\RefreshTokenProviderInterface;
use Zamat\OAuth2\RefreshToken;

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
        return $refreshToken;
    }
    
    public function remove($token)
    {
        return $token;
    }
    
  
    
}