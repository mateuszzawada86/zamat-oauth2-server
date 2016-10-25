<?php
namespace Zamat\OAuth2\Client;

/**
 * Description of OAuthClientInterface
 * @author mateusz.zawada
 */
interface OAuthClientInterface
{
    public function getAccessToken($parameters = array());
}
