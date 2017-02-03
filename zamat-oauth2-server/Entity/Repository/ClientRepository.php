<?php

namespace Zamat\Bundle\OAuth2ServerBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

use Zamat\OAuth2\Provider\ClientProviderInterface;
use Zamat\OAuth2\Client;

use Zamat\Bundle\OAuth2ServerBundle\Entity\Client as ClientEntity;

/**
 * Description of ClientRepository
 * @author mateusz.zawada
 */
class ClientRepository extends EntityRepository implements ClientProviderInterface
{
    
    /**
     * 
     * @param Client $client
     * @return Client
     */
    public function save(Client $client)
    {
        $entity = new ClientEntity();
        $entity->setClientId($client->getClientId());
        $entity->setClientSecret($client->getClientSecret());
        $entity->setGrantTypes($client->getGrantTypes());
        $entity->setPublicKey($client->getPublicKey());
        $entity->setRedirectUri($client->getRedirectUri());
        $entity->setScopes($client->getScopes());

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $client;
    }

}