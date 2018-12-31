<?php

namespace App\Controller;

use App\Entity\Objet;
use App\Entity\Transaction;
use App\Entity\User;
use App\Form\TransactionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/transaction")
 */
class TransactionController extends AbstractController
{
    /**
     * @Route("/", name="transaction_index", methods={"GET"})
     */
    public function index(): Response
    {
        $transactions = $this->getDoctrine()
            ->getRepository(Transaction::class)
            ->findAll();

        return $this->render('transaction/index.html.twig', ['transactions' => $transactions]);
    }

    /**
     * @Route("/new", name="transaction_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $transaction = new Transaction();
        $objet =  $this->getDoctrine()->getManager()->getRepository(Objet::class)->findOneBy(['idobjet' => $request->query->get('id_objet')]);
        $user_demandeur = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['iduser' => $request->query->get('user_demandeur')]);
        $user_offrant = $request->query->get('user_offrant');
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $transaction->setIdobjet($objet);
            $transaction->setIduserdemandeur($user_demandeur);
            $transaction->setIduseroffrant($this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['iduser' => $user_offrant]));
            $transaction->setTransactionrealisee(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($transaction);
            $entityManager->flush();

            $objet->setIdtransaction($this->getDoctrine()->getManager()->getRepository(Transaction::class)->find($transaction));
            $objet->setIdproprietaire($user_demandeur);
            $objet->setDisponible(false);
            $entityManager->persist($objet);
            $entityManager->flush();
            return $this->redirectToRoute('objet_index');
        }

        return $this->render('transaction/new.html.twig', [
            'transaction' => $transaction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idtransaction}", name="transaction_show", methods={"GET"})
     */
    public function show(Transaction $transaction): Response
    {
        return $this->render('transaction/show.html.twig', ['transaction' => $transaction]);
    }

    /**
     * @Route("/{idtransaction}/edit", name="transaction_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Transaction $transaction): Response
    {
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('transaction_index', ['idtransaction' => $transaction->getIdtransaction()]);
        }

        return $this->render('transaction/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idtransaction}", name="transaction_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Transaction $transaction): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transaction->getIdtransaction(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($transaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('transaction_index');
    }
}
