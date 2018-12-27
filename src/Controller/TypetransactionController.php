<?php

namespace App\Controller;

use App\Entity\Typetransaction;
use App\Form\TypetransactionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/typetransaction")
 */
class TypetransactionController extends AbstractController
{
    /**
     * @Route("/", name="typetransaction_index", methods={"GET"})
     */
    public function index(): Response
    {
        $typetransactions = $this->getDoctrine()
            ->getRepository(Typetransaction::class)
            ->findAll();

        return $this->render('typetransaction/index.html.twig', ['typetransactions' => $typetransactions]);
    }

    /**
     * @Route("/new", name="typetransaction_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typetransaction = new Typetransaction();
        $form = $this->createForm(TypetransactionType::class, $typetransaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typetransaction);
            $entityManager->flush();

            return $this->redirectToRoute('typetransaction_index');
        }

        return $this->render('typetransaction/new.html.twig', [
            'typetransaction' => $typetransaction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idtypetransaction}", name="typetransaction_show", methods={"GET"})
     */
    public function show(Typetransaction $typetransaction): Response
    {
        return $this->render('typetransaction/show.html.twig', ['typetransaction' => $typetransaction]);
    }

    /**
     * @Route("/{idtypetransaction}/edit", name="typetransaction_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Typetransaction $typetransaction): Response
    {
        $form = $this->createForm(TypetransactionType::class, $typetransaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('typetransaction_index', ['idtypetransaction' => $typetransaction->getIdtypetransaction()]);
        }

        return $this->render('typetransaction/edit.html.twig', [
            'typetransaction' => $typetransaction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idtypetransaction}", name="typetransaction_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Typetransaction $typetransaction): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typetransaction->getIdtypetransaction(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typetransaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('typetransaction_index');
    }
}
