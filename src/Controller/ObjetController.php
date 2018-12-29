<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Objet;
use App\Entity\Photo;
use App\Form\ObjetType;
use App\Form\PhotoType;
use App\Upload\FileObjetUpload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/objet")
 */
class ObjetController extends AbstractController
{
    /**
     * @Route("/", name="objet_index", methods={"GET"})
     */
    public function index(TokenStorageInterface $tokenStorage): Response
    {
        $user = $tokenStorage->getToken()->getUser();
        $objets = $this->getDoctrine()
            ->getRepository(Objet::class)
            ->findAll();

        $categories = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->findAll();

        return $this->render('objet/index.html.twig', ['objets' => $objets,'user' =>$user,'categories' => $categories]);
    }

    /**
     * @Route("/new", name="objet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $objet = new Objet();
        $form = $this->createForm(ObjetType::class, $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($objet);
            $entityManager->flush();

            return $this->redirectToRoute('objet_index');
        }

        return $this->render('objet/new.html.twig', [
            'objet' => $objet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idobjet}", name="objet_show", methods={"GET"})
     */
    public function show(Objet $objet): Response
    {
        $listePhotosObjet = $this->getDoctrine()
            ->getRepository(Photo::class)
            ->findBy(array('objetobjet'=>$objet));
        return $this->render('objet/show.html.twig', ['objet' => $objet,'photosObjet' => $listePhotosObjet]);
    }

    /**
     * @Route("/{idobjet}/edit", name="objet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Objet $objet): Response
    {
        $form = $this->createForm(ObjetType::class, $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('objet_index', ['idobjet' => $objet->getIdobjet()]);
        }
        $listePhotosObjet = $this->getDoctrine()
            ->getRepository(Photo::class)
            ->findBy(array('objetobjet'=>$objet));
        return $this->render('objet/edit.html.twig', [
            'objet' => $objet,
            'form' => $form->createView(),
            'listePhotos' => $listePhotosObjet
        ]);
    }

    /**
     * @Route("/{idobjet}", name="objet_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Objet $objet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$objet->getIdobjet(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($objet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('objet_index');
    }

    /**
     * @Route("/filterObject/{id}", name="filter_objects", methods={"GET","POST"})
     */
    public function FiltreObjetSelonCategorie(Request $request): Response
    {
        $objetsOfCategorie =$this->getDoctrine()->getManager()->getRepository(Objet::class)->findBy(['idcategorie'=> $request->query->get('id_categorie')]);

        $categories = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->findAll();

        return $this->render('objet/index.html.twig', ['objets' => $objetsOfCategorie,'categories' => $categories]);


    }

}
