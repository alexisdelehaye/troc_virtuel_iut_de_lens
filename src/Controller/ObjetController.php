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
    public function new(Request $request, TokenStorageInterface $tokenStorage): Response
    {
        $user = $tokenStorage->getToken()->getUser();

        if ($user !== 'anon.') {
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
        return $this->redirectToRoute('objet_show');

    }

    /**
     * @Route("/{idobjet}", name="objet_show", methods={"GET"})
     */
    public function show(Objet $objet, TokenStorageInterface $tokenStorage): Response
    {
        $user = $tokenStorage->getToken()->getUser();
        $listePhotosObjet = $this->getDoctrine()
            ->getRepository(Photo::class)
            ->findBy(array('objetobjet' => $objet));

        $listeDemandesObjet = ($user == $objet->getIdproprietaire()) ? $this->getDoctrine()
            ->getRepository(Conversation::class)
            ->findBy(array('idobjetconcerne' => $objet->getIdobjet())) : null;


        return $this->render('objet/show.html.twig', ['objet' => $objet, 'photosObjet' => $listePhotosObjet, 'DemandesObjet' => $listeDemandesObjet]);
    }


    /**
     * @Route("/{idobjet}/edit", name="objet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Objet $objet, TokenStorageInterface $tokenStorage): Response
    {
        $user = $tokenStorage->getToken()->getUser();

        if ($user !== 'anon.' && $user == $objet->getIdproprietaire()) {

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

        return $this->redirectToRoute('objet_index');
    }

    /**
     * @Route("/{idobjet}", name="objet_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Objet $objet, TokenStorageInterface $tokenStorage): Response
    {
        $user = $tokenStorage->getToken()->getUser();

        if ($user !== 'anon.' && $user == $objet->getIdproprietaire()) {

            if ($this->isCsrfTokenValid('delete' . $objet->getIdobjet(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($objet);
                $entityManager->flush();
            }
        }

        return $this->redirectToRoute('objet_index');
    }

    /**
     * @Route("/filterObject/{id}", name="filter_objects", methods={"GET","POST"})
     */
    public function FiltreObjetSelonCategorie(Request $request): Response
    {
        $objetsOfCategorie = $this->getDoctrine()->getManager()->getRepository(Objet::class)->findBy(['idcategorie' => $request->query->get('id_categorie')]);
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
    public function showUsersObject(): Response // ne marche pas sans encune raison ( retourne tjr App\Entity\Objet object not found by the @ParamConverter annotation.)
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

    public function getObjetsPretes(array $listePret) {
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
