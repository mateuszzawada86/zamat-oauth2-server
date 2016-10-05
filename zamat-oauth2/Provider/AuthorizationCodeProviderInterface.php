<?php
namespace Zamat\OAuth2\Provider;
use Zamat\OAuth2\AuthorizationCode;

/**
 * Description of AuthorizationCodeProviderInterface
 * @author mateusz.zawada
 */
interface AuthorizationCodeProviderInterface
{
    public function find($id);
    public function save(AuthorizationCode $accessToken);
    public function remove($code);
}
