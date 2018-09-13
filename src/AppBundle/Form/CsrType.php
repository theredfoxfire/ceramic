<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CsrType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array('label' => 'Title'))
            ->add('story', 'textarea', array(
                'label' => 'Short Story',
                'required' => false,
                'attr' => array('class' => 'tinymce', 'rows' => 15),
            ))
            ->add('largeImage', 'file', array('required' => false, 'label' => 'Foto (image file, best fit width 1280px x height 793px) ', 'data' => null))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Csr',
            'allow_extra_fields' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'csr';
    }
}
