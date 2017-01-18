<?php

namespace Zamat\Bundle\OAuth2Bundle\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

class OAuth2AuthorizationFactory implements SecurityFactoryInterface
{
    
    /**
     *
     * @var type 
     */
    protected $options = array();
    
    /**
     * 
     * @param ContainerBuilder $container
     * @param type $id
     * @param type $config
     * @param type $userProviderId
     * @param type $defaultEntryPointId
     * @return type
     */
    public function create(ContainerBuilder $container, $id, $config, $userProviderId, $defaultEntryPointId)
    {
        $authProviderId = $this->createAuthProvider($container, $id, $config, $userProviderId);
        $listenerId = $this->createListener($container, $id, $config, $userProviderId);
        $entryPointId = $this->createEntryPoint($container, $id, $config, $defaultEntryPointId);
        return array($authProviderId, $listenerId, $entryPointId);
    }    
    
    
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
        $container->setDefinition($providerId, new DefinitionDecorator('oauth.security.authentication.provider'));
        
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
        
        $listenerId = $this->getListenerId();
        $listener = new DefinitionDecorator($listenerId);
        $listener->replaceArgument(4, $id);
        $listener->replaceArgument(5, new Reference($this->createAuthenticationSuccessHandler($container, $id, $config)));
        $listener->replaceArgument(6, new Reference($this->createAuthenticationFailureHandler($container, $id, $config)));
        $listener->replaceArgument(7, array_intersect_key($config, $this->options));

        $listenerId .= '.'.$id;
        $container->setDefinition($listenerId, $listener);
        
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
     * @return type
     */
    protected function createAuthenticationSuccessHandler($container, $id, $config)
    {
        $successHandlerId = $this->getSuccessHandlerId($id);

        $successHandler = $container->setDefinition($successHandlerId, new DefinitionDecorator('security.authentication.success_handler'));
        $successHandler->addMethodCall('setProviderKey', array($id));

        return $successHandlerId;
    }

    /**
     * 
     * @param type $container
     * @param type $id
     * @param type $config
     * @return type
     */
    protected function createAuthenticationFailureHandler($container, $id, $config)
    {
        $id = $this->getFailureHandlerId($id);
        $failureHandler = $container->setDefinition($id, new DefinitionDecorator('security.authentication.failure_handler'));
 
        return $id;
    }  
    
    /**
     * 
     * @param type $id
     * @return type
     */
    protected function getSuccessHandlerId($id)
    {
        return 'security.authentication.success_handler.'.$id.'.'.str_replace('-', '_', $this->getKey());
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    protected function getFailureHandlerId($id)
    {
        return 'security.authentication.failure_handler.'.$id.'.'.str_replace('-', '_', $this->getKey());
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

