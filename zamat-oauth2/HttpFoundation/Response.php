<?php

namespace Zamat\OAuth2\HttpFoundation;

use Symfony\Component\HttpFoundation\JsonResponse;
use OAuth2\ResponseInterface;

/**
 * Symfony Response Bridge
 */
 class Response extends JsonResponse implements ResponseInterface
 {
   
     /**
      * 
      * @param array $parameters
      */
    public function addParameters(array $parameters)
    {
        // if there are existing parametes, add to them
        if ($this->content && $data = json_decode($this->content, true)) {
            $parameters = array_merge($data, $parameters);
        }
        // this will encode the php array as json data
        $this->setData($parameters);
    }

    /**
     * 
     * @param array $httpHeaders
     */
    public function addHttpHeaders(array $httpHeaders)
    {
        foreach ($httpHeaders as $key => $value) {
            $this->headers->set($key, $value);
        }
    }

    /**
     * 
     * @param type $name
     * @return type
     */
    public function getParameter($name)
    {
        if ($this->content && $data = json_decode($this->content, true)) {
            return isset($data[$name]) ? $data[$name] : null;
        }
    }

    /**
     * 
     * @param type $statusCode
     * @param type $error
     * @param type $description
     * @param type $uri
     */
    public function setError($statusCode, $error, $description = null, $uri = null)
    {
        $this->setStatusCode($statusCode);
        $this->addParameters(array_filter(array(
            'error'             => $error,
            'error_description' => $description,
            'error_uri'         => $uri,
        )));
    }

    /**
     * 
     * @param type $statusCode
     * @param string $url
     * @param type $state
     * @param type $error
     * @param type $errorDescription
     * @param type $errorUri
     */
    public function setRedirect($statusCode = 302, $url, $state = null, $error = null, $errorDescription = null, $errorUri = null)
    {
        $this->setStatusCode($statusCode);

        $params = array_filter(array(
            'state'             => $state,
            'error'             => $error,
            'error_description' => $errorDescription,
            'error_uri'         => $errorUri,
        ));

        if ($params) {
            $parts = parse_url($url);
            $sep = isset($parts['query']) && count($parts['query']) > 0 ? '&' : '?';
            $url .= $sep . http_build_query($params);
        }
        $this->headers->set('Location', $url);
    }
 }
