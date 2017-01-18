<?php

namespace Zamat\Bundle\OAuth2Bundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Zamat\Bundle\OAuth2Bundle\DependencyInjection\ZamatOAuth2Extension;

class ZamatOAuth2Bundle extends Bundle
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
            return new ZamatOAuth2Extension();
        }
        return $this->extension;
    } 

}
