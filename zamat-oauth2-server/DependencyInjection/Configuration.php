<?php

namespace Zamat\Bundle\OAuth2ServerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $builder->root('zamat_oauth2_server')
            ->children()
                ->scalarNode('zamat_oauth_user_provider')->end()
                ->scalarNode('zamat_oauth_client_provider')->end()
                ->scalarNode('zamat_oauth_scope_provider')->end()
                ->scalarNode('zamat_oauth_authorization_code_provider')->end()
                ->scalarNode('zamat_oauth_access_token_provider')->end()
                ->scalarNode('zamat_oauth_refresh_token_provider')->end()
                ->scalarNode('zamat_oauth_client_publickey_provider')->end()                
            ->end(); 
        
        return $builder;              
    }
}
