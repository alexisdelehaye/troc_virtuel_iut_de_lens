<?php

namespace App\Form;

use App\Entity\Conversation;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ConversationType extends AbstractType
{

    private $securityChecker;
    private $token;

    public function __construct(AuthorizationCheckerInterface $securityChecker, TokenStorageInterface $token)
    {
        $this->securityChecker = $securityChecker;
        $this->token = $token;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contenu')
            ->add('date')
            ->add('idenvoyeur')
            ->add('idobjetconcerne')
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Conversation::class,
        ]);
    }


    public function preSetData(FormEvent $event)
    {

        $form = $event->getForm();
        $conversation = $event->getData();
        //@explain set User and remove user field in form
        $conversation->setIdenvoyeur($this->token->getToken()->getUser());
        $currentDate = new DateTime('now');
        $conversation->setDate($currentDate->format('d-m-Y H:i:s'));
        $form->remove('date');
        $form->remove('idenvoyeur');
        $form->remove('idobjetconcerne');

    }
}
