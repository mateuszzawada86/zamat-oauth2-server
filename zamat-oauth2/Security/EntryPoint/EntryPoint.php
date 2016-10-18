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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\HttpKernel\HttpKernelInterface;

use Zamat\OAuth2\Client\OAuthParameters;

/**
 * OAuthEntryPoint redirects the user to the appropriate login url if there is
 * only one resource owner. Otherwise the user will be redirected to a login
 * page.
 *
 */
class EntryPoint implements AuthenticationEntryPointInterface
{
    /**
     * @var HttpKernelInterface
     */
    protected $httpKernel;

    /**
     * @var HttpUtils
     */
    protected $httpUtils;

    /**
     * @var string
     */
    protected $loginPath;

    /**
     * @var Boolean
     */
    protected $useForward;

    /**
     * Constructor
     *
     * @param HttpUtils $httpUtils
     * @param string    $loginPath
     * @param Boolean   $useForward
     */
    public function __construct(HttpKernelInterface $kernel, HttpUtils $httpUtils,OAuthParameters $parameters, $useForward = false)
    {
        $this->httpKernel = $kernel;
        $this->httpUtils  = $httpUtils;
        $this->useForward = (Boolean) $useForward; 
        
        $this->loginPath  = $parameters->getConnectUrl();
     
    }

    /**
     * {@inheritDoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        if ($this->useForward) {
            $subRequest = $this->httpUtils->createRequest($request, $this->loginPath);
            $subRequest->query->add($request->query->getIterator()->getArrayCopy());
            
            $response = $this->httpKernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
            if (200 === $response->getStatusCode()) {
                $response->headers->set('X-Status-Code', 401);
            }

            return $response;
        }

        return $this->httpUtils->createRedirectResponse($request, $this->loginPath);
    }
}
