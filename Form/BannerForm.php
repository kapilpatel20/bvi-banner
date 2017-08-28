<?php

namespace BviBannerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BannerForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder,array $options) {

    	$builder->add('title', 'text')
                ->add('image', 'file', array('data_class' => null))
                ->add('status', 'choice', array('choices' => array('Active' => 'Active', 'Inactive' => 'Inactive'), 'multiple' => false, 'expanded' => true,
                'empty_value' => false));
    }

    public function getName() {
        return 'banner';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'BviBannerBundle\Entity\Banner'
        ));
    }

}

