<?php

namespace App\Form\Admin;

use App\Entity\User;
use App\Form\Type\RolesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomuser',TextType::class)
            ->add('prenompersonne',TextType::class)
            ->add('emailuser',EmailType::class)
            ->add('pseudo',TextType::class)
            ->add('passworduser',PasswordType::class)
            ->add('roles', RolesType::class)
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );
    }

    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $user = $event->getData();
        //si on edite, on met le champ password en optionnel, afin de ne pas etre obligé de le renseigner
        if($user->getIduser() !== null){
            $form->remove('passworduser');
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
