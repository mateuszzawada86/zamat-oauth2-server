<?php
namespace Zamat\OAuth2\Provider;
use Zamat\OAuth2\AccessToken;

/**
 * Description of AccessTokenProviderInterface
 * @author mateusz.zawada
 */
interface AccessTokenProviderInterface
{
    public function find($id);
    public function save(AccessToken $accessToken);
}
