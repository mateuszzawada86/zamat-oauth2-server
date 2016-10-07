<?php

namespace Zamat\Bundle\OAuth2Bundle\Entity;
use Zamat\OAuth2\User as BaseUser;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 */
class User extends BaseUser implements UserInterface
{

}
