<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DownloadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('overview', 'textarea', array(
                'required' => false,
                'attr' => array(
                  'class' => 'tinymce',
                  'rows' => '10'
                ),
            ))
            ->add('file', 'file', array(
              'label' => 'File ',
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
            'data_class' => 'AppBundle\Entity\Download'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'download';
    }
}
