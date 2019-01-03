<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Objet;
use App\Repository\ObjetRepository;
use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index()
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function searchBar() {

        $form = $this->createFormBuilder(null)
            ->add('requete', TextType::class )
            ->add('search', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])->getForm();

        return $this->render('search/searchBar.html.twig', [
            'form' => $form->createView()

        ]);
    }


    /**
     * @Route("/searchObjets", name="search_objets")
     * @param Request $request
     */

    public function handleSearch (Request $request,ObjetRepository $objetRepository, PhotoRepository $photoRepository){
        $formData = $request->get("form");
        $searchObjet = $objetRepository->searchObjetByName($formData['requete']);

        $listePhotos = array();
        if(sizeof($searchObjet)> 0){
            foreach ($searchObjet as $objet){
                array_push($listePhotos,$photoRepository->getMainPictureOfObjectById($objet->getIdobjet()));
            }
        }

        return $this->render('objet/searchSpecificObjects.html.twig', ['objets' => $searchObjet,'categories' => $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->findAll(),'photos' => $listePhotos, 'recherche' => $formData['requete']]);

    }
}
