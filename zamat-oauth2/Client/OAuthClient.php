<?php

namespace Zamat\OAuth2\Client;

use Buzz\Message\Request as HttpRequest;
use Buzz\Message\Response as HttpResponse;
use Buzz\Client\Curl;

use Zamat\OAuth2\HttpFoundation\Request;

class OAuthClient
{

    /**
     *
     * @var Request 
     */
    protected $request;

    /**
     *
     * @var OAuthClientParameters 
     */
    protected $clientParameters;

    /**
     *
     * @var OAuthParameters 
     */
    protected $options;
    

    /**
     * 
     * @param RequestInterface $request
     * @param \Zamat\OAuth2\Client\OAuthClientParameters $clientParameters
     */
    public function __construct(Request $request, OAuthClientParameters $clientParameters, OAuthParameters $parameters)
    {
        $this->request = $request;
        $this->clientParameters = $clientParameters;
        $this->options = $parameters;
    }

    /**
     * 
     * @return type
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * 
     * @param RequestInterface $request
     * @return \Zamat\OAuth2\Client\OAuthClient
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getClientParameters()
    {
        return $this->clientParameters;
    }

    /**
     * 
     * @param \Zamat\OAuth2\Client\OAuthClientParameters $clientParameters
     * @return \Zamat\OAuth2\Client\OAuthClient
     */
    public function setClientParameters(OAuthClientParameters $clientParameters)
    {
        $this->clientParameters = $clientParameters;
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getOptions()
    {
        return $this->options;
    }


    /**
     * 
     * generate access token for given authorization code
     * @param type $code
     * @return \Zamat\OAuth2\Client\OAuthClient
     */
    public function getAccessToken()
    {

        $params = array(
            'client_id' => $this->getClientParameters()->getClient(),
            'client_secret' => $this->getClientParameters()->getClientSecret(),
            'scope' => $this->getClientParameters()->getScopes(),
            'redirect_uri' => $this->getClientParameters()->getRedirectUrl(),
            'code' => $this->getRequest()->get('code'),
            'state' => $this->generateState(),
            'grant_type' => 'authorization_code',
        );

        $request = new HttpRequest(Request::METHOD_POST, $this->getOptions()->getTokenUrl());
        $request->setContent(http_build_query($params));

        $response = new HttpResponse();

        $client = new Curl();
        $client->send($request, $response);

        return $response->getContent();
    }
    
    /**
     * generate authorization url
     * @param array $extraParameters
     * @return type
     */
    public function generateAuthorizationUrl(array $extraParameters = array())
    {

        $parameters = array_merge(array(
            'response_type' => 'code',
            'client_id' => $this->getClientParameters()->getClient(),
            'scope' => $this->getClientParameters()->getScopes(),
            'state' => $this->generateState(),
            'redirect_uri' => $this->getClientParameters()->getRedirectUrl()
        ), $extraParameters);

        return $this->normalizeUrl($this->getOptions()->getAuthorizeUrl(), $parameters);
    } 
    
    
    /**
     * normalize url
     * @param string $url
     * @param array  $parameters
     *
     * @return string
     */
    protected function normalizeUrl($url, array $parameters = array())
    {
        $normalizedUrl = $url;
        if (!empty($parameters)) {
            $normalizedUrl .= (false !== strpos($url, '?') ? '&' : '?').http_build_query($parameters, '', '&');
        }
        
        return $normalizedUrl;
    } 

    /**
     * generate unique state
     * @return type
     */
    public function generateState()
    {
        return uniqid();
    }

}
