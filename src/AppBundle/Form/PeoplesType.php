<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PeoplesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('position')
            ->add('story', 'textarea', array(
                'required' => false,
                'attr' => array(
                  'class' => 'tinymce',
                  'rows' => '20'
                ),
            ))
            ->add('largeImage', 'file', array(
              'label' => 'Foto (image file, best fit width 800px x height 600px)',
               'data' => null,
               'required' => false,
             ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Peoples'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'peoples';
    }
}
