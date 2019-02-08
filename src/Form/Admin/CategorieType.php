<?php

namespace App\Form\Admin;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    private $categorieParent;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->categorieParent = $options['categorieParent'];
        $builder
            ->add('nomcategorie')
            ->add('descriptioncategorie')
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );
    }

    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $categorie = $event->getData();
        if($this->categorieParent !== null && $this->categorieParent instanceof Categorie)
        {
            $categorie->setCategoriePere($this->categorieParent);
        }
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
            'categorieParent' => null
        ]);
    }
}
