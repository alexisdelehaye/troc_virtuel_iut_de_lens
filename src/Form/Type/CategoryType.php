<?php

namespace App\Form\Type;

use App\Repository\CategorieRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CategoryType extends AbstractType
{
    private $repo;

    public function __construct(CategorieRepository $repo)
    {
        $this->repo = $repo;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => $this->getChoices()
        ]);
    }

    private function getChoices()
    {
        $categories = $this->repo->findAllParentCategory();

        $arr = [];
        foreach($categories as $parent)
        {
            $arr[$parent->getNomcategorie()] = [];
            foreach ($parent->getCategories() as $children)
            {
                $arr[$parent->getNomcategorie()][$children->getNomcategorie()] = $children->getIdcategorie();
            }
        }

        return $arr;
    }

    public function getParent(){
        return ChoiceType::class;
    }
}
