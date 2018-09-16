<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OverviewType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('overview', 'textarea', array(
                'label' => 'Brief overview about contact us',
                'required' => false,
                'attr' => array(
                  'class' => 'form-control',
                  'rows' => '6',
                  'placeholder' => 'MESSAGE'
                ),
            ))
            ->add('mainAddress', 'textarea', array(
                'label' => 'Address',
                'required' => false,
                'attr' => array(
                  'class' => 'form-control',
                  'rows' => '6',
                  'placeholder' => 'MESSAGE'
                ),
            ))
            // ->add('longitude', 'text', array(
            //     'label' => 'Google Map Longitude',
            //     'required' => false,
            //     'attr' => array(
            //       'class' => 'form-control',
            //       'rows' => '6',
            //       'placeholder' => 'longitude'
            //     ),
            // ))
            // ->add('latitude', 'text', array(
            //     'label' => 'Google Map Latitude',
            //     'required' => false,
            //     'attr' => array(
            //       'class' => 'form-control',
            //       'rows' => '6',
            //       'placeholder' => 'latitude'
            //     ),
            // ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Overview'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'overview';
    }
}
