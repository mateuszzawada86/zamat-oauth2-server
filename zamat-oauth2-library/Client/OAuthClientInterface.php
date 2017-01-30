<?php
namespace Zamat\OAuth2\Client;

/**
 * Description of OAuthClientInterface
 * @author mateusz.zawada
 */
interface OAuthClientInterface
{
    public function __construct(array $clientParameters);
    
    public function setClientParameters(array $clientParameters);
    public function getClientParameters();
    public function getUserInformation($accessToken);
    public function getAccessToken($parameters = array());
        
}
