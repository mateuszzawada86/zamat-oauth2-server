<?php

namespace Zamat\OAuth2\HttpFoundation;

use Symfony\Component\HttpFoundation\Request as BaseRequest;
use Symfony\Component\HttpFoundation\HeaderBag;
use OAuth2\RequestInterface;

/**
 * Symfony Request Bridge
 */
class Request extends BaseRequest implements RequestInterface
{

    /**
     * 
     * @param type $name
     * @param type $default
     * @return type
     */
    public function query($name, $default = null)
    {
        return $this->query->get($name, $default);
    }

    /**
     * 
     * @param type $name
     * @param type $default
     * @return type
     */
    public function request($name, $default = null)
    {
        return $this->request->get($name, $default);
    }

    /**
     * 
     * @param type $name
     * @param type $default
     * @return type
     */
    public function server($name, $default = null)
    {
        return $this->server->get($name, $default);
    }

    /**
     * 
     * @param type $name
     * @param type $default
     * @return type
     */
    public function headers($name, $default = null)
    {
        return $this->headers->get($name, $default);
    }

    /**
     * 
     * @return type
     */
    public function getAllQueryParameters()
    {
        return $this->query->all();
    }

    /**
     * 
     * @param BaseRequest $request
     * @return \static
     */
    public static function createFromRequest()
    {

        $request = BaseRequest::createFromGlobals();
        return new static($request->query->all(), $request->request->all(), $request->attributes->all(), $request->cookies->all(), $request->files->all(), $request->server->all(), $request->getContent());
    }

    /**
     * 
     * @return type
     */
    public static function createFromGlobals()
    {
        $request = parent::createFromGlobals();
        self::fixAuthHeader($request->headers);

        return $request;
    }

    /**
     * 
     * @param \Symfony\Component\HttpFoundation\HeaderBag $headers
     */
    private static function fixAuthHeader(HeaderBag $headers)
    {
        if (!$headers->has('Authorization') && function_exists('apache_request_headers')) {
            $all = apache_request_headers();
            if (isset($all['Authorization'])) {
                $headers->set('Authorization', $all['Authorization']);
            }
        }
    }

}
