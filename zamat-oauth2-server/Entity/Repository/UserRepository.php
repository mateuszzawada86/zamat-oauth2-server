<?php

namespace Zamat\Bundle\OAuth2Bundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;
use Zamat\OAuth2\Provider\UserProviderInterface;

/**
 * Description of UserRepository
 * @author mateusz.zawada
 */
class UserRepository extends EntityRepository  implements UserProviderInterface
{
    /**
     * 
     * @param string $username
     * @return object
     */
    public function findOneByUsername($username)
    {
        return $this->findOneBy(array("username" => $username));
    }

}