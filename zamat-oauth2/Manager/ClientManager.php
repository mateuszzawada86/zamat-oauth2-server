<?php

namespace Zamat\OAuth2\Manager;

use Doctrine\ORM\EntityManager;
use OAuth2\Exception\ScopeNotFoundException;

class ClientManager
{
    
    private $entityManager;

    /**
     * @var ScopeManagerInterface
     */
    private $sm;

    public function __construct(EntityManager $entityManager, ScopeManagerInterface $scopeManager)
    {
        $this->em = $entityManager;
        $this->sm = $scopeManager;
    }

    /**
     * Creates a new client
     *
     * @param string $identifier
     *
     * @param array $redirect_uris
     *
     * @param array $grant_type
     *
     * @param array $scopes
     *
     * @return Client
     */
    public function createClient($identifier, array $redirect_uris = array(), array $grant_types = array(), array $scopes = array())
    {
        $client = new \Zamat\Bundle\OAuth2Bundle\Entity\Client();
        $client->setClientId($identifier);
        $client->setClientSecret($this->generateSecret());
        $client->setRedirectUri($redirect_uris);
        $client->setGrantTypes($grant_types);

        // Verify scopes
        foreach ($scopes as $scope) {
            // Get Scope
            $scopeObject = $this->sm->findScopeByScope($scope);
            if (!$scopeObject) {
                throw new ScopeNotFoundException();
            }
        }

        $client->setScopes($scopes);

        // Store Client
        $this->em->persist($client);
        $this->em->flush();

        return $client;
    }

    /**
     * Creates a secret for a client
     *
     * @return A secret
     */
    protected function generateSecret()
    {
        return base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }
}
