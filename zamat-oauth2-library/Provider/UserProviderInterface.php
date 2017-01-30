<?php
namespace Zamat\OAuth2\Provider;

/**
 * Description of UserProviderInterface
 * @author mateusz.zawada
 */
interface UserProviderInterface {

   public function findOneByUsername($username);  
}
