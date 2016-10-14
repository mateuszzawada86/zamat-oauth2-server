<?php

namespace Zamat\OAuth2\Security\Factory;

/**
 * OAuthFactory class.
 */
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Zamat\OAuth2\Security\EntryPoint\OAuthEntryPoint;

class OAuth2Factory implements SecurityFactoryInterface
{
    
    /**
     * 
     * @param ContainerBuilder $container
     * @param type $id
     * @param type $config
     * @param type $userProvider
     * @param type $defaultEntryPoint
     * @return type
     */
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {

        $providerId = 'security.authentication.provider.oauth.'.$id;
        $container->setDefinition($providerId, new DefinitionDecorator('oauth.security.authentication.provider'));
        
        $listenerId = 'security.authentication.listener.oauth.'.$id;
        $listener = $container->setDefinition($listenerId, new DefinitionDecorator('oauth.security.authentication.listener'));
        
        return array(
            $providerId, 
            $listenerId, 
            'oauth.security.entry_point'
        );
    }

    /**
     * 
     * @return string
     */
    public function getPosition()
    {
        return 'pre_auth';
    }

    /**
     * 
     * @return string
     */
    public function getKey()
    {
        return 'oaut2h';
    }

    /**
     * 
     * @param NodeDefinition $node
     */
    public function addConfiguration(NodeDefinition $node)
    {
        
    }
}