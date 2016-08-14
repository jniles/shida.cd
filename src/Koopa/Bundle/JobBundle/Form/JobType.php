<?php

namespace Koopa\Bundle\JobBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class JobType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('summary')
            ->add('active', null, array(
                'required' => false
            ))
            ->add(
                'timeLeft',
                DateType::class,
                array(
                    'widget' => 'single_text',
                    'attr' => array(
                        'data-provide' => 'datepicker',
                        'data-date-format' => 'dd-mm-yyyy'
                    )
                )
            )
            ->add(
                'startAt',
                DateType::class,
                array(
                    'widget' => 'single_text',
                    'attr' => array(
                        'data-provide' => 'datepicker',
                        'data-date-format' => 'dd-mm-yyyy'
                    )
                )
            )
            ->add(
                'paymentMethod',
                ChoiceType::class,
                array(
                    'choices' => array(
                        'per_month' => 'par mois',
                        'per_hour' => 'par heure',
                    )
                )
            )
            // ->add('salary', 'text')
            // ->add('experience', 'integer')
            ->add(
                'skills',
                EntityType::class,
                array(
                    'class' => 'KoopaJobBundle:Skill',
                    'choice_label' => 'name',
                    'multiple' => true
                )
            )
            ->add(
                'locations',
                EntityType::class,
                array(
                    'class' => 'KoopaJobBundle:Location',
                    'choice_label' => 'town',
                    'multiple' => true
                )
            )
            ->add(
                'subCategories',
                EntityType::class,
                array(
                    'class' => 'KoopaJobBundle:SubCategory',
                    'choice_label' => 'name',
                    'multiple' => true
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
                'data_class' => 'Koopa\Bundle\JobBundle\Entity\Job'
            )
        );
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'job_job';
    }
}
