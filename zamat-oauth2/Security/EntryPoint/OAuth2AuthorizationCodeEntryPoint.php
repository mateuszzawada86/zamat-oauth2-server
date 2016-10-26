<?php



/*
 * This file is part of the HWIOAuthBundle package.
 *
 * (c) Hardware.Info <opensource@hardware.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zamat\OAuth2\Security\EntryPoint;


use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class OAuth2AuthorizationCodeEntryPoint implements AuthenticationEntryPointInterface
{
    
    /**
     *
     * @var type 
     */
    private $clientId;
    private $clientSecret;
    private $redirectUri;
    private $scope;
    
    /**
     *
     * @var array 
     */
    protected $clientParameters;
       
    /**
     * @Container Parameters
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
     * @param array $parameters
     * @return \Zamat\OAuth2\Security\EntryPoint\OAuth2AuthorizationCodeEntryPoint
     */
    public function setParameters(array $parameters = array())
    {
        $this->clientId = $parameters['client_id'];
        $this->clientSecret = $parameters['client_secret'];
        $this->redirectUri = $parameters['redirect_uri'];
        $this->scope = $parameters['scope'];

        return $this;
    }
    
    /**
     * 
     * client parameters[] : authorize_uri
     * @param type $clientParameters
     */
    public function __construct($clientParameters = array())
    {
        $this->clientParameters = $clientParameters;
    }

    /**
     * Starts the authentication scheme.
     *
     * @param Request                 $request       The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     *
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {

        $state = uniqid(rand());
        $session = $request->getSession();
        $session->set('state', $state);
                        
        return new RedirectResponse($this->getClientParameters()['authorize_uri'] . '?' . http_build_query(array(
                    'response_type' => 'code',
                    'client_id' => $this->clientId,
                    'redirect_uri' => $this->redirectUri,
                    'scope' => $this->scope,
                    'state' => $state,
        )));
    }
}
