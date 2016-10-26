<?php

namespace Zamat\Bundle\OAuth2Bundle\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;


class OAuth2AuthorizationFactory extends AbstractFactory
{
    
    /**
     * 
     * @return string
     */
    public function getPosition()
    {
        return 'http';
    }
    
    /**
     * 
     * @return string
     */
    public function getKey()
    {
        return 'oauth2_authorization_code';
    }
    
    /**
     * 
     * @param NodeDefinition $node
     */
    public function addConfiguration(NodeDefinition $node)
    {
        parent::addConfiguration($node);
        $node
            ->children()
                ->scalarNode('client_id')->defaultValue('')->end()
                ->scalarNode('client_secret')->defaultValue('')->end()
                ->scalarNode('scope')->defaultValue('user')->end()          
                ->scalarNode('redirect_uri')->defaultValue('http://www.example.com')->end()
                ->scalarNode('validate_ssl')->defaultValue('http://www.example.com')->end()          
            ->end();
    }
           
    /**
     * 
     * @param ContainerBuilder $container
     * @param type $id
     * @param type $config
     * @param type $userProviderId
     * @return string
     */
    protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
    {
        $providerId = 'oauth.security.authentication.provider.'.$id;
        $container
            ->setDefinition($providerId, new DefinitionDecorator('oauth.security.authentication.provider'))
            ->replaceArgument(0, new Reference($userProviderId));
        
        return $providerId;
    }
    
    /**
     * 
     * @return string
     */
    protected function getListenerId()
    {
        return 'oauth.security.authentication.listener';
    }
    
    /**
     * 
     * @param type $container
     * @param type $id
     * @param type $config
     * @param type $userProvider
     * @return type
     */
    protected function createListener($container, $id, $config, $userProvider)
    {
                
        $listenerId = parent::createListener($container, $id, $config, $userProvider);
        $container
            ->getDefinition($listenerId)
            ->addMethodCall('setParameters', array($config))
            ->addArgument(new Reference('oauth.security.authentication.client'));
        return $listenerId;
    }
    
    /**
     * 
     * @param type $container
     * @param type $id
     * @param type $config
     * @param type $defaultEntryPoint
     * @return string
     */
    protected function createEntryPoint($container, $id, $config, $defaultEntryPoint)
    {
        $entryPointId = 'oauth.client.security.entry_point.'.$id;
        $container
            ->setDefinition($entryPointId, new DefinitionDecorator('oauth.client.security.entry_point'))
            ->addMethodCall('setParameters', array($config));
        return $entryPointId;
    }
}

