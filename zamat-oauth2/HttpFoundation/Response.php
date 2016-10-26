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
     * @return \Zamat\OAuth2\HttpFoundation\Response
     */
    public function addParameters(array $parameters)
    {
        if ($this->content && $data = json_decode($this->content, true)) {
            $parameters = array_merge($data, $parameters);
        }
        $this->setData($parameters);
        return $this;
    }

    /**
     * 
     * @param array $httpHeaders
     * @return \Zamat\OAuth2\HttpFoundation\Response
     */
    public function addHttpHeaders(array $httpHeaders)
    {
        foreach ($httpHeaders as $key => $value) {
            $this->headers->set($key, $value);
        }
        return $this;
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
        return null;
    }

    /**
     * 
     * @param type $statusCode
     * @param type $error
     * @param type $description
     * @param type $uri
     * @return \Zamat\OAuth2\HttpFoundation\Response
     */
    public function setError($statusCode, $error, $description = null, $uri = null)
    {
        $this->setStatusCode($statusCode);
        $this->addParameters(array_filter(array(
            'error' => $error,
            'error_description' => $description,
            'error_uri' => $uri,
        )));
        return $this;
    }

    /**
     * 
     * @param type $statusCode
     * @param string $url
     * @param type $state
     * @param type $error
     * @param type $errorDescription
     * @param type $errorUri
     * @return \Zamat\OAuth2\HttpFoundation\Response
     */
    public function setRedirect($statusCode, $url, $state = null, $error = null, $errorDescription = null, $errorUri = null)
    {
        $this->setStatusCode($statusCode);

        $params = array_filter(array(
            'state' => $state,
            'error' => $error,
            'error_description' => $errorDescription,
            'error_uri' => $errorUri,
        ));

        if ($params) {
            $parts = parse_url($url);
            $sep = isset($parts['query']) && count($parts['query']) > 0 ? '&' : '?';
            $url .= $sep . http_build_query($params);
        }
        $this->headers->set('Location', $url);
        return $this;
    }

}
