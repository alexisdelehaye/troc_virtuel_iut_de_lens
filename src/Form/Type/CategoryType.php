<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CategoryType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
       //todo
    }

    public function getParent(){
        return ChoiceType::class;
    }
}
