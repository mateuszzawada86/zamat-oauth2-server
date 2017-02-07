<?php

namespace Zamat\Bundle\OAuth2ServerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Zamat\Bundle\OAuth2ServerBundle\DependencyInjection\ZamatOAuth2ServerExtension;

class ZamatOAuth2ServerBundle extends Bundle
{

    /**
     * 
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {      
        parent::build($container);                 
    }
    
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            return new ZamatOAuth2ServerExtension();
        }
        return $this->extension;
    } 

}
