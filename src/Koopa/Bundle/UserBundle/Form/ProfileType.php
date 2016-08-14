<?php

namespace Koopa\Bundle\UserBundle\Form;

use Koopa\Bundle\AppBundle\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use FOS\UserBundle\Form\Type\ProfileFormType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', ChoiceType::class, array(
                'choices' => array(
                    'male' => 'Homme',
                    'female' => 'Femme'
                )
            ))
            ->add('firstname')
            ->add('lastname')
            ->add('image', ImageType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Koopa\Bundle\UserBundle\Entity\User'
        ));
    }

    public function getParent()
    {
        return ProfileFormType::class;
    }

    public function getBlockPrefix()
    {
        return 'koopa_user_profile';
    }
}
