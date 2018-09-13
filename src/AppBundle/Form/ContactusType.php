<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactusType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', 'text', array(
          'label' => false,
          'attr' => array(
            'class' => 'form-control',
            'size' => '56',
            'placeholder' => 'NAME'
          ),
        ))
        ->add('email', 'email', array(
            'label' => false,
            'attr' => array(
              'class' => 'form-control',
              'size' => '56',
              'placeholder' => 'EMAIL'
            ),
        ))
        ->add('title', 'text', array(
            'label' => false,
            'attr' => array(
              'class' => 'form-control',
              'size' => '56',
              'placeholder' => 'SUBJECT'
            ),
        ))
        ->add('message', 'textarea', array(
            'label' => false,
            'required' => false,
            'attr' => array(
              'class' => 'form-control',
              'rows' => '6',
              'placeholder' => 'MESSAGE'
            ),
        ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Contactus'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'contactus';
    }
}
