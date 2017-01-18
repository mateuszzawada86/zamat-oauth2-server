<?php

namespace Zamat\Bundle\OAuth2Bundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ZamatOAuth2Extension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
                
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        
        $container->setParameter('zamat_oauth2_server.authorize_uri', $config['authorize_uri']);
        $container->setParameter('zamat_oauth2_server.token_uri', $config['token_uri']);
        $container->setParameter('zamat_oauth2_server.verify_uri', $config['verify_uri']);
 
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'zamat_oauth2_server';
    }  
    
    
}