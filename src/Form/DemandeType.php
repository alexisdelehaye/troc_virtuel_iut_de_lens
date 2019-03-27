<?php

namespace App\Form;

use App\Entity\Demande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DemandeType extends AbstractType
{
    private $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomdemande')
            ->add('datedemande')
            ->add('demandesatisfaite')
            ->add('idcategorie')
            ->add('idtypetransaction', TypetransactionType::class)
            ->add('iduser')
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }

    public function preSetData(FormEvent $event)
    {

        $form = $event->getForm();
        $demande = $event->getData();
        $demande->setIduser($this->token->getToken()->getUser());
        $demande->setDatedemande(new \DateTime());
        $demande->setDemandesatisfaite(false);
        $form->remove('demandesatisfaite');
        $form->remove('iduser');
        $form->remove('datedemande');

    }
}
