<?php

namespace Koopa\Bundle\JobBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SubCategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add(
                'category',
                EntityType::class,
                array(
                    'class' => 'KoopaJobBundle:Category',
                    'choice_label' => 'name'
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Koopa\Bundle\JobBundle\Entity\SubCategory'
            )
        );
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'job_subcategory';
    }
}
