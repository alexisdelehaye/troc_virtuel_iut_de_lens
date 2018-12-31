<?php

namespace App\Form;

use App\Entity\Transaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('transactionrealisee')
            ->add('idobjet')
            ->add('idtypetranasaction')
            ->add('iduserdemandeur')
            ->add('iduseroffrant')
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }


    public function preSetData(FormEvent $event)
    {

        $form = $event->getForm();
        $form->remove('transactionrealisee');
        $form->remove('idobjet');
        $form->remove('iduserdemandeur');
        $form->remove('iduseroffrant');

    }
}
