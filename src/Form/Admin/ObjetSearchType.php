<?php
namespace App\Form\Admin;

use App\Entity\Admin\ObjetSearch;
use App\Entity\Categorie;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjetSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('users', EntityType::class, [
                'required' => false,
                'class' => User::class,
                'choice_label' => 'emailuser',
                'multiple' => true
                ])
            ->add('categories', EntityType::class, [
                'required' => false,
                'class' => Categorie::class,
                'choice_label' => 'nomcategorie',
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ObjetSearch::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
