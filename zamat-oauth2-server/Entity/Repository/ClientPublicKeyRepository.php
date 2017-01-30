<?php

namespace Zamat\Bundle\OAuth2Bundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;
use Zamat\OAuth2\Provider\ClientPublicKeyProviderInterface;

/**
 * Description of ClientPublicKeyRepository
 * @author mateusz.zawada
 */
class ClientPublicKeyRepository extends EntityRepository implements ClientPublicKeyProviderInterface
{
  
}