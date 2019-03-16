<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\Objet;
use App\Form\ConversationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/conversation")
 */
class ConversationController extends AbstractController
{
    /**
     * @Route("/", name="conversation_index", methods={"GET"})
     */
    public function index(): Response
    {
        $conversations = $this->getDoctrine()
            ->getRepository(Conversation::class)
            ->findAll();

        return $this->render('conversation/index.html.twig', ['conversations' => $conversations]);
    }

    /**
     * @Route("/new/{objet}", name="conversation_new", methods={"GET","POST"}, defaults={"objet"=null})
     */
    public function new(Request $request, TokenStorageInterface $tokenStorage, Objet $objet = null): Response
    {
        $user = $tokenStorage->getToken()->getUser();

        if ($user !== 'anon.') {
            $conversation = new Conversation();
            $form = $this->createForm(ConversationType::class, $conversation, ['objet' => $objet]);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($conversation);
                $entityManager->flush();

                return $this->redirectToRoute('objet_show', ['idobjet' => $conversation->getIdobjetconcerne()->getIdobjet()]);
            }

            return $this->render('conversation/new.html.twig', [
                'conversation' => $conversation,
                'form' => $form->createView(),
            ]);

        }
        return $this->redirectToRoute('objet_index');
    }

    /**
     * @Route("/{idconversation}", name="conversation_show", methods={"GET"})
     */
    public function show(Conversation $conversation, TokenStorageInterface $tokenStorage): Response // acces au message uniquement pour l'user destinataire et celui  qui l'a envoyé
    {
        $user = $tokenStorage->getToken()->getUser();

        if ($user !== 'anon.' && ($user == $conversation->getIdobjetconcerne()->getIdproprietaire() || $user == $conversation->getIdenvoyeur())) {
            $listeMessage = $this->getDoctrine()->getManager()->getRepository(Message::class)->findBy(['conversationconversation' => $conversation]);
            return $this->render('conversation/show.html.twig', ['conversation' => $conversation, 'messages' => $listeMessage]);
        }

        return $this->redirectToRoute('objet_index');
    }

    /**
     * @Route("/{idconversation}/edit", name="conversation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Conversation $conversation): Response
    {
        $form = $this->createForm(ConversationType::class, $conversation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('conversation_index', ['idconversation' => $conversation->getIdconversation()]);
        }

        return $this->render('conversation/edit.html.twig', [
            'conversation' => $conversation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idconversation}", name="conversation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Conversation $conversation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$conversation->getIdconversation(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($conversation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('conversation_index');
    }
}
