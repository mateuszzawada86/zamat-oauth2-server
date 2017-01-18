<?php

namespace Zamat\Bundle\OAuth2Bundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Zamat\Bundle\OAuth2Bundle\Entity\Client;

class LoadClient extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    
    /**
     * @var ContainerInterface
     */
    private $container;
    
    /**
     * 
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    } 
    
    /**
     * 
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
         
        $client = new Client();
        $client->setClientId("api");
        $client->setClientSecret("api");
        $client->setScopes(array("api"));
        $client->setGrantTypes(array("password","authorization_code"));
        $client->setRedirectUri(array("http://google.pl"));
           
        $manager->persist($client);       
            
        
        $manager->flush();
    }
    
    /**
     * 
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }  
}