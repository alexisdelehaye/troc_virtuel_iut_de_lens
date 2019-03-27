<?php

namespace App\Form;

use App\Entity\Transaction;
use App\Entity\Typetransaction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    private $conversation;
    private $nomTransaction;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->conversation = $options['conversation'];
        $this->nomTransaction = $options['nomTransaction'];
        $builder
            ->add('idobjet')
            ->add('idtypetranasaction')
            ->add('iduserdemandeur')
            ->add('iduseroffrant')
            ->add('transactionrealisee');

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );


        if ($this->nomTransaction == 'prêt') {
            $builder ->add('idtypetranasaction', TypetransactionType::class);
            $builder->addEventListener(
                FormEvents::POST_SET_DATA,
                array($this, 'postSetData')
            );

        }
        else {
            $builder ->add('idtypetranasaction');
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
            'conversation' => null,
            'nomTransaction' => null
        ]);
    }


    public function postSetData(FormEvent $event)
    {
        $transactionPret = $event->getData();
        $form = $event->getForm();
        $transactionPret->setIdtypetranasaction($form->get('idtypetranasaction')->getData());
    }


    public function preSetData(FormEvent $event)
    {
        $transactionPret = $event->getData();
        $form = $event->getForm();

        $transactionPret->setIdobjet($this->conversation->getIdobjetconcerne());
        $transactionPret->setIduserdemandeur($this->conversation->getIdenvoyeur());
        $transactionPret->setIduseroffrant($this->conversation->getIdobjetconcerne()->getIdproprietaire());
        $transactionPret->setTransactionrealisee(true);
        $this->conversation->getIdobjetconcerne()->setDisponible(false);
        $form->remove('transactionrealisee');
        $form->remove('idobjet');
        $form->remove('iduserdemandeur');
        $form->remove('iduseroffrant');

        if($this->nomTransaction == 'don') {
            $transactionPret->setIdtypetranasaction($this->em->getRepository(Typetransaction::class)->findOneBy(['nomtransaction' => 'don']));
            $form->remove('idtypetranasaction');
            $form->add('submit', SubmitType::class, ['label_format' => 'donner cette objet à '.$this->conversation->getIdenvoyeur()]);
        }

    }
}
