<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomuser')
            ->add('prenompersonne')
            ->add('emailuser')
            ->add('passworduser',RepeatedType::class, array(
        'type' => PasswordType::class,
        'first_options' => array('label' => 'Password'),
        'second_options' => array('label' => 'Repeat Password')))
            ->add('pseudo')
            ->add('avatar')
            ->add('idprofil')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
