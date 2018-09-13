<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UnitesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array('label' => 'Name'))
            ->add('subtitle', null, array('label' => 'Sub name'))
            ->add('category', null, array('empty_data' => '-- Please select business category --', 'attr' => array('placeholder' => 'Please select business category')))
            ->add('story', 'textarea', array(
                'label' => 'Short Story',
                'required' => false,
                'attr' => array('class' => 'tinymce', 'rows' => '15'),
            ))
            ->add('largeImage', 'file', array('required' => false, 'label' => 'Foto (image file, best fit width 1280px x height 793px Max size 2MB) ', 'data' => null))
            ->add('webUrl', null, array('required' => false, 'label' => 'Website Address'))
        ;
    }


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Unites',
            'allow_extra_fields' => true,
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'unites';
    }
}
