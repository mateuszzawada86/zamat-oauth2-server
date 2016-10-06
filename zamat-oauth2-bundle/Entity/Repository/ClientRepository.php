<?php

namespace Zamat\Bundle\OAuth2Bundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;
use Zamat\OAuth2\Provider\ClientProviderInterface;

/**
 * Description of ClientRepository
 * @author mateusz.zawada
 */
class ClientRepository extends EntityRepository implements ClientProviderInterface
{
  
}