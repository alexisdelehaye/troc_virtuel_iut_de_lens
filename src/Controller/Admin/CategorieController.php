<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Form\Admin\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/categorie", name="admin_categorie_")
 * @IsGranted("ROLE_ADMIN")
 */
class CategorieController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findAllParentCategory();

        return $this->render('admin/categorie/index.html.twig', ['categories' => $categories]);
    }

    /**
     * @Route("/new/{idcategorie}", name="new", methods={"GET","POST"},defaults={"idcategorie" = null})
     */
    public function new(Request $request,Categorie $categorieParent = null): Response
    {
        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie, ['categorieParent' => $categorieParent]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();

            $this->addFlash('success', 'La catégorie a été créé avec succès.');


            return $this->redirectToRoute('admin_categorie_index');
        }

        return $this->render('admin/categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idcategorie}", name="show", methods={"GET"})
     */
    public function show(Categorie $categorie): Response
    {
        return $this->render('admin/categorie/show.html.twig', ['categorie' => $categorie]);
    }

    /**
     * @Route("/{idcategorie}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Categorie $categorie): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La catégorie a été modifié avec succès.');

            return $this->redirectToRoute('admin_categorie_show', ['idcategorie' => $categorie->getIdcategorie()]);
        }

        return $this->render('admin/categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idcategorie}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Categorie $categorie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getIdcategorie(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categorie);
            $entityManager->flush();
            $this->addFlash('success', 'La catégorie a été supprimé avec succès.');
        }else{
            $this->addFlash('error', 'Erreur lors de la suppression de la catégorie.');
        }

        return $this->redirectToRoute('admin_categorie_index');
    }
}
