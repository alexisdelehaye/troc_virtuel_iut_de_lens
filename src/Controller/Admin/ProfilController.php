<?php

namespace App\Controller\Admin;

use App\Entity\Profil;
use App\Form\Admin\ProfilType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/profil", name="admin_profil_")*
 * @IsGranted("ROLE_ADMIN")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        $profils = $this->getDoctrine()
            ->getRepository(Profil::class)
            ->findAll();

        return $this->render('admin/profil/index.html.twig', ['profils' => $profils]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $profil = new Profil();
        $form = $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($profil);
            $entityManager->flush();

            return $this->redirectToRoute('admin_profil_index');
        }

        return $this->render('admin/profil/new.html.twig', [
            'profil' => $profil,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idprofil}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Profil $profil): Response
    {
        $form = $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_profil_index');
        }

        return $this->render('admin/profil/edit.html.twig', [
            'profil' => $profil,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idprofil}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Profil $profil): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profil->getIdprofil(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($profil);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_profil_index');
    }
}
