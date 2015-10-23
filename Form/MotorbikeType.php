<?php

namespace Rth\MotorbikeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MotorbikeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('make')
            ->add('model')
            ->add('cc')
            ->add('weight',null, array('label' => 'weight (kg)'))
            ->add('color')
            ->add('price')
            ->add('image', 'file', array('label' => 'image (jpg / png)'))
            ->add('submit', 'submit')    
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rth\MotorbikeBundle\Entity\Motorbike'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rth_motorbikebundle_motorbike';
    }
}
