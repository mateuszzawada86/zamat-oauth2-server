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
    protected $serverAuthorizeUri;
    protected $serverTokenUri;
    protected $clientId;
    protected $clientSecret;
    protected $authorizationRedirectUri;
    protected $redirectUri;
    protected $scope;
    
    /**
     * 
     * @param array $parameters
     * @return \Zamat\OAuth2\Security\EntryPoint\OAuth2AuthorizationCodeEntryPoint
     */
    public function setParameters(array $parameters = array())
    {
        $this->serverAuthorizeUri = $parameters['authorize_uri'];
        $this->serverTokenUri = $parameters['token_uri'];
        $this->clientId = $parameters['client_id'];
        $this->clientSecret = $parameters['client_secret'];
        $this->redirectUri = $parameters['redirect_uri'];
        $this->scope = $parameters['scope'];

        return $this;
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
        $state = uniqid();
        $session = $request->getSession();
        $session->set('state', $state);
        
        $params = array(
            'response_type' => 'code',
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'scope' => $this->scope,
            'state' => $state,
        );
                
        return new RedirectResponse($this->serverAuthorizeUri .'?' . http_build_query($params));
    }
}
