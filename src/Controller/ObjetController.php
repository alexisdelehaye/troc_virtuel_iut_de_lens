<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Conversation;
use App\Entity\Objet;
use App\Entity\Photo;
use App\Entity\Transaction;
use App\Entity\Typetransaction;
use App\Form\ObjetType;
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
    public function index(): Response
    {
        $objets = $this->getDoctrine()
            ->getRepository(Objet::class)
            ->findBy(['disponible' => true]);

        $categories = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->findAll();

        $photos = $this->getDoctrine()
            ->getRepository(Photo::class)
            ->findBy(['imageprincipale' => true]);

        return $this->render('objet/index.html.twig', ['objets' => $objets, 'categories' => $categories, 'photos' => $photos]);
    }

    /**
     * @Route("/new", name="objet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $objet = new Objet();
        $form = $this->createForm(ObjetType::class, $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($objet);
            $entityManager->flush();
            return $this->redirectToRoute('objet_show',['idobjet' => $objet->getIdobjet()]);
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
            ->findBy(array('objetobjet' => $objet));

        $listeDemandesObjet = ($this->getUser() == $objet->getIdproprietaire()) ? $this->getDoctrine()
            ->getRepository(Conversation::class)
            ->findBy(array('idobjetconcerne' => $objet->getIdobjet())) : null;


        return $this->render('objet/show.html.twig', ['objet' => $objet, 'photosObjet' => $listePhotosObjet, 'DemandesObjet' => $listeDemandesObjet]);
    }

    /**
     * @Route("/{idobjet}/edit", name="objet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Objet $objet): Response

    {
        $this->denyAccessUnlessGranted('OBJET_EDIT', $objet);

        $form = $this->createForm(ObjetType::class, $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('objet_index', ['idobjet' => $objet->getIdobjet()]);
        }
        $listePhotosObjet = $this->getDoctrine()
            ->getRepository(Photo::class)
            ->findBy(array('objetobjet' => $objet));

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
        $this->denyAccessUnlessGranted('OBJET_DELETE', $objet);

        if ($this->isCsrfTokenValid('delete' . $objet->getIdobjet(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($objet);
            $entityManager->flush();
        }
    }

    /**
     * @Route("/filterObject/{id}", name="filter_objects", methods={"GET","POST"}, defaults={"id"=null})
     */
    public function FiltreObjetSelonCategorie(Categorie $id=null): Response
    {
        $objetsOfCategorie = $this->getDoctrine()->getManager()->getRepository(Objet::class)->findBy(['idcategorie' => $id]);
        $categories = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->findAll();

        $listePhotos = $this->getDoctrine()
            ->getRepository(Photo::class)
            ->findBy(['imageprincipale' => true]);

        return $this->render('objet/index.html.twig', ['objets' => $objetsOfCategorie, 'categories' => $categories, 'photos' => $listePhotos]);
    }

    /**
     * @Route("/user/showUsersObject", name="objet_showUsersObject", methods={"GET"})
     */
    public function showUsersObject(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $listeObjets = $this->getDoctrine()
            ->getRepository('App\Entity\Objet')
            ->findBy(['idproprietaire' => $this->getUser()->getIduser()]);
        return $this->render('objet/listeObjectsConnectedUser.html.twig', ['objets' => $listeObjets, 'user' => $this->getUser()]);
    }

    /**
     * @Route("/user/showUsersObjectPret", name="objet_showUsersObjectPret", methods={"GET","POST"})
     */
    public function showUsersObjectPret(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $listePret = $this->getDoctrine()
            ->getRepository(Typetransaction::class)
            ->listePretObjets();
        $listeObjetsPretes = $this->getObjetsPretes($listePret);

       return $this->render('objet/listeObjetsPretees.html.twig', ['listeObjetsPretes' => $listeObjetsPretes, 'user' => $this->getUser()]);
    }

    public function getObjetsPretes(array $listePret)
    {
        $listeObjetsPretes = array();
        foreach ($listePret as $pret){
            $objet = $this->getDoctrine()
                ->getRepository(Transaction::class)
                ->findOneBy(['idtypetranasaction' => $pret->getIdtypetransaction(), 'iduseroffrant' => $this->getUser()]);
            if(is_null($objet) === false) {
                array_push($listeObjetsPretes, $objet);
            }
        }
        return $listeObjetsPretes;
    }
}
