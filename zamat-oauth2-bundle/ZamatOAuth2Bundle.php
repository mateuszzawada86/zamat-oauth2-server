<?php

namespace Zamat\Bundle\OAuth2Bundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Zamat\OAuth2\Security\Factory\OAuth2Factory;

class ZamatOAuth2Bundle extends Bundle
{
    
    /**
     * 
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new OAuth2Factory());
    }   
}
