<?php

namespace Zamat\OAuth2\Client;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

use Buzz\Message\Request as HttpRequest;
use Buzz\Message\Response as HttpResponse;
use Buzz\Client\Curl;

use Zamat\OAuth2\HttpFoundation\Request;
use Zamat\OAuth2\Client\OAuthClientInterface;

class OAuthClient implements OAuthClientInterface
{
    
    /**
     *
     * @var array 
     */
    protected $clientParameters;
    
    /**
     * 
     * @param array $clientParameters
     */
    public function __construct(array $clientParameters)
    {
        $this->clientParameters = $clientParameters;
    } 
       
    /**
     * 
     * @param array $clientParameters
     * @return \Zamat\OAuth2\Security\EntryPoint\OAuth2AuthorizationCodeEntryPoint
     */
    public function setClientParameters(array $clientParameters)
    {
        $this->clientParameters = $clientParameters;
        return $this;
    }
       
    /**
     * 
     * @return array
     */
    public function getClientParameters()
    {
        return $this->clientParameters;
    }  
    

    /**
     * 
     * @param type $parameters
     * @return type
     */
    public function getAccessToken($parameters = array())
    {
        
        $params = array(
            'client_id' => $parameters['client_id'],
            'client_secret' => $parameters['client_secret'],
            'scope' => $parameters['scope'],
            'redirect_uri' => $parameters['redirect_uri'],
            'code' => $parameters['code'],
            'grant_type' => 'authorization_code',
        );

        $request = new HttpRequest(Request::METHOD_POST, $this->getClientParameters()['token_uri']);
        $request->setContent(http_build_query($params));

        $response = new HttpResponse();

        $client = new Curl();
        $client->send($request, $response);

        $content = $this->getResponseContent($response);

        return $this->validateResponseContent($content);
    }
    
    /**
     * 
     * @param type $accessToken
     * @return type
     */
    public function getUserInformation($accessToken)
    {
        $request = new HttpRequest(Request::METHOD_POST, $this->getClientParameters()['verify_uri']);
        $request->setHeaders(array('Authorization' => 'Bearer '.$accessToken));
        $response = new HttpResponse();
        $client = new Curl();
        $client->send($request, $response);
                
        return $this->getResponseContent($response);


    } 
    
    /**
     * Get the 'parsed' content based on the response headers.
     * @param HttpMessageInterface $rawResponse
     * @return array
     */
    protected function getResponseContent(HttpResponse $rawResponse)
    {
        $content = $rawResponse->getContent();
        if (!$content) {
            return array();
        }
        $response = json_decode($content, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            parse_str($content, $response);
        }      
        return $response;
    }

    /**
     * @param mixed $response the 'parsed' content based on the response headers
     * @throws AuthenticationException If an OAuth error occurred or no access token is found
     */
    protected function validateResponseContent($response)
    {
        if (isset($response['error_description'])) {
            throw new AuthenticationException(sprintf('OAuth error: "%s"', $response['error_description']));
        }
        if (isset($response['error'])) {
            throw new AuthenticationException(sprintf('OAuth error: "%s"', isset($response['error']['message']) ? $response['error']['message'] : $response['error']));
        }
        if (!isset($response['access_token'])) {
            throw new AuthenticationException('Not a valid access token.');
        }
        return $response;
    }

}
