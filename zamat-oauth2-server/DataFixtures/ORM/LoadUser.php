<?php

namespace Zamat\Bundle\OAuth2ServerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Zamat\Bundle\OAuth2ServerBundle\Entity\User;

class LoadUser extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
         
        $user = new User();
        $user->setEmail("admin");
        $user->setUsername("admin"); 
        $user->setEnabledStatus(true);
        
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, "admin");
        
        $user->setPassword($encoded);   
                      
        $manager->persist($user);       
                
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