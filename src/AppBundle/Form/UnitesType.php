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
            ->add('category', null, array('empty_data' => '-- Please select category --', 'attr' => array('placeholder' => 'Please select category')))
            ->add('colour', null, array('empty_data' => '-- Please select colour --', 'attr' => array('placeholder' => 'Please select colour')))
            ->add('size', null, array('empty_data' => '-- Please select size --', 'attr' => array('placeholder' => 'Please select size')))
            ->add('story', 'textarea', array(
                'label' => 'Deskripsi',
                'required' => false,
                'attr' => array('class' => 'tinymce', 'rows' => '15'),
            ))
            ->add('largeImage', 'file', array('required' => false, 'label' => 'Gambar Utama (image file, best fit 400x400) ', 'data' => null))
            ->add('price', null, array('required' => false, 'label' => 'Harga'))
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
