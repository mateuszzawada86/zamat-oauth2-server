<?php

namespace Zamat\OAuth2\Exception;

class UserNotFoundException extends \Exception
{

    /**
     * {@inheritDoc}
     */
    public function getMessageKey()
    {
        return 'User could not be found.';
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize(array(
            parent::serialize(),
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($str)
    {
        list($parentData) = unserialize($str);
        parent::unserialize($parentData);
    }

}
