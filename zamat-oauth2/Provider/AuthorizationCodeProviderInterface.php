<?php
namespace Zamat\OAuth2\Provider;
use Zamat\OAuth2\AuthorizationCode;

/**
 * Description of AuthorizationCodeProviderInterface
 * @author mateusz.zawada
 */
interface AuthorizationCodeProviderInterface
{
    public function findCode($code);
    public function save(AuthorizationCode $accessToken);
    public function remove($code);
}
