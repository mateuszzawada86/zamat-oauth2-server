<?php
namespace Zamat\Bundle\OAuth2Bundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Zamat\OAuth2\Provider\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Zamat\Bundle\OAuth2Bundle\Entity\User;
/**
 * Description of UserRepository
 * @author mateusz.zawada
 */
class UserRepository extends EntityRepository implements UserProviderInterface
{

    /**
     *
     * @var EncoderFactoryInterface 
     */
    private $encoderFactory;
    
    /**
     * 
     * @return type
     */
    public function getEncoderFactory()
    {
        return $this->encoderFactory;
    }

    /**
     * 
     * @param EncoderFactoryInterface $encoderFactory
     * @return \Zamat\Bundle\OAuth2Bundle\Entity\Repository\UserRepository
     */
    public function setEncoderFactory(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
        return $this;
    }

    /**
     * 
     * @param type $username
     * @return type
     */
    public function loadUserByUsername($username)
    {
        return $this->findOneBy(array('username' => $username));
    }
    
    /**
     * 
     * @param UserInterface $user
     * @return type
     * @throws UnsupportedUserException
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof UserInterface) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }
    

    /**
     * 
     * @param type $class
     * @return type
     */
    public function supportsClass($class)
    {
        return $class === __NAMESPACE__;
    }
    
    
    /**
     * Creates a new user
     *
     * @param string $username
     *
     * @param string $password
     *
     * @param array $roles
     *
     * @param array $scopes
     *
     * @return UserInterface
     */
    public function createUser($username, $password, array $roles = array(), array $scopes = array())
    {
        $user = new User();
        
        $user->setUsername($username);
        $user->setRoles($roles);
        $user->setScopes($scopes);

        $salt = $this->generateSalt();
        $pass = $this->encoderFactory->getEncoder($user)->encodePassword($password, $salt);

        $user->setSalt($salt);
        $user->setPassword($pass);

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $user;
    }

    /**
     * Creates a salt for password hashing
     * @return A salt
     */
    protected function generateSalt()
    {
        return base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }   
  
}