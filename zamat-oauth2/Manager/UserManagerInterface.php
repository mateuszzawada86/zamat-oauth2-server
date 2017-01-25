<?php

namespace Zamat\OAuth2\Manager;
use Symfony\Component\Security\Core\User\UserProviderInterface;

interface UserManagerInterface extends UserProviderInterface
{
    public function loadUserWithScopes($username);
}
