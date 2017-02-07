<?php

namespace Zamat\Bundle\OAuth2ServerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

class OverrideServiceCompilerPass implements CompilerPassInterface
{
    /**
     *
     * @var array 
     */
    private $configuration = array();

    /**
     * 
     * @param array $configuration
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * 
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (array_key_exists('zamat_oauth_user_provider', $this->configuration)) {
            $container->removeDefinition('zamat_oauth.user.provider');
            $container->setDefinition('zamat_oauth.user.provider', new DefinitionDecorator($this->configuration['zamat_oauth_user_provider']));
        }
        if (array_key_exists('zamat_oauth_client_provider', $this->configuration)) {
            $container->removeDefinition('zamat_oauth.client.provider');
            $container->setDefinition('zamat_oauth.client.provider', new DefinitionDecorator($this->configuration['zamat_oauth_client_provider']));
        }
        if (array_key_exists('zamat_oauth_scope_provider', $this->configuration)) {
            $container->removeDefinition('zamat_oauth.scope.provider');
            $container->setDefinition('zamat_oauth.scope.provider', new DefinitionDecorator($this->configuration['zamat_oauth_scope_provider']));
        }       
        if (array_key_exists('zamat_oauth_authorization_code_provider', $this->configuration)) {
            $container->removeDefinition('zamat_oauth.authorization.code.provider');
            $container->setDefinition('zamat_oauth.authorization.code.provider', new DefinitionDecorator($this->configuration['zamat_oauth_authorization_code_provider']));
        }   
        if (array_key_exists('zamat_oauth_access_token_provider', $this->configuration)) {
            $container->removeDefinition('zamat_oauth.access.token.provider');
            $container->setDefinition('zamat_oauth.access.token.provider', new DefinitionDecorator($this->configuration['zamat_oauth_access_token_provider']));
        }        
        if (array_key_exists('zamat_oauth_refresh_token_provider', $this->configuration)) {
            $container->removeDefinition('zamat_oauth.refresh.token.provider');
            $container->setDefinition('zamat_oauth.refresh.token.provider', new DefinitionDecorator($this->configuration['zamat_oauth_refresh_token_provider']));
        }         
        if (array_key_exists('zamat_oauth_client_publickey_provider', $this->configuration)) {
            $container->removeDefinition('zamat_oauth.client.publickey.provider');
            $container->setDefinition('zamat_oauth.client.publickey.provider', new DefinitionDecorator($this->configuration['zamat_oauth_client_publickey_provider']));
        }   
              
    }

}
