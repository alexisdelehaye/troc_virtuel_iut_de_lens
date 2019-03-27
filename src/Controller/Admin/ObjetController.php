<?php

namespace App\Controller\Admin;

use App\Entity\Admin\ObjetSearch;
use App\Entity\Objet;
use App\Entity\Photo;
use App\Form\Admin\ObjetSearchType;
use App\Repository\Admin\ObjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/objet", name="admin_objet_")
 * @IsGranted("ROLE_ADMIN")
 */
class ObjetController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, ObjetRepository $repo)
    {
        $search = new ObjetSearch();
        $form = $this->createForm(ObjetSearchType::class, $search);
        $form->handleRequest($request);

        $objets = $repo->findAllByCustomSearch($search);
        dump($objets);
        return $this->render('admin/objet/index.html.twig', [
            'objets' => $objets,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{idobjet}", name="show", methods={"GET"})
     */
    public function show(Objet $objet): Response
    {
        return $this->render('admin/objet/show.html.twig', ['objet' => $objet]);
    }

    /**
     * @Route("/{idobjet}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Objet $objet): Response
    {

    }

    /**
     * @Route("/{idobjet}/photos", name="photos", methods={"GET","POST"})
     */
    public function photo(Objet $objet): Response
    {
        return $this->render('admin/objet/photos.html.twig', ['objet' => $objet]);
    }

    /**
     * @Route("/{idobjet}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Objet $objet): Response
    {

        if ($this->isCsrfTokenValid('delete' . $objet->getIdobjet(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($objet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_objet_index');
    }


    /**
     * @Route("/{idobjet}/photos/{idphoto}", name="photo_delete", methods={"DELETE"})
     */
    public function deletePhoto(Request $request, Objet $objet, Photo $photo): Response
    {

        if ($this->isCsrfTokenValid('delete' . $photo->getIdphoto(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($photo);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_objet_photos', ['idobjet' => $objet->getIdobjet()]);
    }
}
