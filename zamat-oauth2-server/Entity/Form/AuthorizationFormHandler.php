<?php

namespace Zamat\Bundle\OAuth2ServerBundle\Entity\Form;

use Symfony\Component\Form\FormInterface;
use OAuth2\RequestInterface;
use Zamat\Bundle\OAuth2ServerBundle\Model\Authorization;
use Symfony\Component\HttpFoundation\Request;

class AuthorizationFormHandler
{

    /**
     * Authorization Form
     * @var FormInterface
     */
    protected $form;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * 
     * @param FormInterface $form
     * @param RequestInterface $request
     */
    public function __construct(FormInterface $form, RequestInterface $request = null)
    {
        $this->form = $form;
        $this->request = $request;
    }

    /**
     * 
     * @return type
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * 
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * 
     * @param FormInterface $form
     * @return \Zamat\Bundle\OAuth2ServerBundle\Entity\Form\AuthorizeFormHandler
     */
    public function setForm(FormInterface $form)
    {
        $this->form = $form;
        return $this;
    }

    /**
     * 
     * @param RequestInterface $requestStack
     * @return \Zamat\Bundle\OAuth2ServerBundle\Entity\Form\AuthorizeFormHandler
     */
    public function setRequest(RequestInterface $requestStack)
    {
        $this->request = $requestStack;
        return $this;
    }

    /**
     * 
     * @return boolean
     */
    public function isAccepted()
    {
        return $this->getForm()->getData()->getAccepted();
    }

    /**
     * 
     * @return boolean
     */
    public function isRejected()
    {
        return !$this->isAccepted();
    }

    /**
     * 
     * @return type
     */
    public function getScope()
    {
        return $this->getForm()->getData()->getScope();
    }

    /**
     * 
     * @return boolean
     */
    public function process()
    {
        $request = $this->getRequest();

        $authorization = new Authorization();
        $authorization->setAccepted($request->request->has('accepted'));
        $authorization->bind($request->query->all());

        $form = $this->getForm();
        $form->setData($authorization);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->onSuccess();
                return true;
            }
        }
        return false;
    }

    /**
     * Put form data in $_GET so that OAuth2 library will call Request::createFromGlobals().
     * @todo finishClientAuthorization() is a bit odd since it accepts $data
     * but then proceeds to ignore it and forces everything to be in $request->query
     */
    protected function onSuccess()
    {
        $_GET = array(
            'client_id' => $this->getForm()->getData()->getClientId(),
            'response_type' => $this->getForm()->getData()->getResponseType(),
            'redirect_uri' => $this->getForm()->getData()->getRedirectUrl(),
            'state' => $this->getForm()->getData()->getState(),
            'scope' => $this->getForm()->getData()->getScope(),
        );

        return $this;
    }

}
