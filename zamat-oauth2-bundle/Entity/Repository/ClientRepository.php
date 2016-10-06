<?php

namespace Zamat\Bundle\OAuth2Bundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

use Zamat\OAuth2\Provider\ClientProviderInterface;
use Zamat\OAuth2\Client;

/**
 * Description of ClientRepository
 * @author mateusz.zawada
 */
class ClientRepository extends EntityRepository implements ClientProviderInterface
{
    public function save(Client $client)
    {
        return $client;
    }
}