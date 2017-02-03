<?php

namespace Zamat\Bundle\OAuth2ServerBundle\Entity\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Zamat\Bundle\OAuth2ServerBundle\Model\Authorization;


class AuthorizationForm extends AbstractType
{
    
    /**
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('client_id', HiddenType::class);
        $builder->add('response_type', HiddenType::class);
        $builder->add('redirect_uri', HiddenType::class);
        $builder->add('state', HiddenType::class);
        $builder->add('scope', HiddenType::class);
    }

    /**
     * {@inheritdoc}
     * @todo Remove it when bumping requirements to SF 2.7+
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Authorization::class,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'zamat_oauth_server_authorize';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
