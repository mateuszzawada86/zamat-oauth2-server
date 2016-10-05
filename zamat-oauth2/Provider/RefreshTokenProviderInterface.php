<?php
namespace Zamat\OAuth2\Provider;
use Zamat\OAuth2\RefreshToken;

/**
 * Description of AccessTokenProviderInterface
 * @author mateusz.zawada
 */
interface RefreshTokenProviderInterface
{
    public function find($id);
    public function save(RefreshToken $accessToken);
    public function remove($token);
  
}
