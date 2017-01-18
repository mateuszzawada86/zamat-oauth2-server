<?php

namespace Zamat\Bundle\OAuth2Bundle\DependencyInjection;

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
            ->addDefaultsIfNotSet()             
            ->children()
                ->scalarNode('authorize_uri')->defaultValue('http://example.com')->end()
                ->scalarNode('token_uri')->defaultValue('http://example.com')->end()
                ->scalarNode('verify_uri')->defaultValue('http://example.com')->end()
            ->end();
        
        
        return $builder;     
        
        
    }
}
