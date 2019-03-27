<?php

namespace App\Controller;

use App\Entity\Objet;
use App\Entity\Photo;
use App\Form\PhotoType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/photo")
 */
class PhotoController extends AbstractController
{
    /**
     * @Route("/", name="photo_index", methods={"GET"})
     */
    public function index(): Response
    {
        $photos = $this->getDoctrine()
            ->getRepository(Photo::class)
            ->findAll();

        return $this->render('photo/index.html.twig', ['photos' => $photos]);
    }

    /**
     * @Route("/{idobjet}/new", name="add_photo_to_objet", methods={"GET","POST"},  defaults={"idobjet"=null})
     */
    public function new(Objet $idobjet = null, Request $request): Response
    {
        $this->denyAccessUnlessGranted('PHOTO_ADD');
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo,['idobjet' => $idobjet]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($photo);
            $entityManager->flush();
            return $this->redirectToRoute('objet_show',['idobjet' => $idobjet->getIdobjet()]);
        }

        return $this->render('photo/new.html.twig', [
            'photo' => $photo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idphoto}", name="photo_show", methods={"GET"})
     */
    public function show(Photo $photo): Response
    {
        return $this->render('photo/show.html.twig', ['photo' => $photo]);
    }

    /**
     * @Route("/{idphoto}/edit", name="photo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Photo $photo): Response
    {
        $this->denyAccessUnlessGranted('PHOTO_EDIT', $photo->getObjetobjet());

        $form = $this->createForm(PhotoType::class, $photo);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('photo_index', ['idphoto' => $photo->getIdphoto()]);
            }

            return $this->render('photo/edit.html.twig', [
                'photo' => $photo,
                'form' => $form->createView(),
            ]);
    }

    /**
     * @Route("/{idphoto}", name="photo_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Photo $photo): Response
    {
        $this->denyAccessUnlessGranted('PHOTO_DELETE', $photo->getObjetobjet());
        if ($this->isCsrfTokenValid('delete' . $photo->getIdphoto(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($photo);
                $entityManager->flush();
            }

    }

}
