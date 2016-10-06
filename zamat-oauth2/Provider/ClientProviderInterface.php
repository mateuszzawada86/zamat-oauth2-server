<?php
namespace Zamat\OAuth2\Provider;
use Zamat\OAuth2\Client;
/**
 * Description of ClientProviderInterface
 * @author mateusz.zawada
 */
interface ClientProviderInterface
{
    public function find($id);
    public function save(Client $client);
}
