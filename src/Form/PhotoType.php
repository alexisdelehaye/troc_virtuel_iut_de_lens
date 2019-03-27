<?php

namespace App\Form;

use App\Entity\Photo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhotoType extends AbstractType
{
    private $objet;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->objet = $options['idobjet'];
        $builder
            ->add('cheminphoto',FileType::class, array('label' => 'Image', 'data_class' => null))
            ->add('imageprincipale')
            ->add('objetobjet')
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            array($this, 'postSubmit')
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
            'idobjet' => null
        ]);
    }


    public function preSetData(FormEvent $event)
    {
        $photo = $event->getData();
        $photo->setObjetobjet($this->objet);
        $form = $event->getForm();
        $form->remove('objetobjet');
    }


    public function postSubmit(FormEvent $event)
    {
        $photo = $event->getData();
        $file = $event->getForm()->get("cheminphoto")->getData();
        $newFileName = rand(1, 99999) . '.' . $file->guessExtension();
        $file->move('img/', $newFileName);
        $photo->setCheminphoto($newFileName);
    }
}
