<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/message")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/", name="message_index", methods={"GET"})
     */
    public function index(): Response
    {
        $messages = $this->getDoctrine()
            ->getRepository(Message::class)
            ->findAll();

        return $this->render('message/index.html.twig', ['messages' => $messages]);
    }

    /**
     * @Route("/new/{conversation}", name="message_new", methods={"GET","POST"}, defaults={"conversation"=null})
     */
    public function new(Request $request, Conversation $conversation = null): Response
    {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $message = new Message();
            $form = $this->createForm(MessageType::class, $message, ['conversation' => $conversation]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($message);
                $entityManager->flush();

                return $this->redirectToRoute('conversation_show', ['idconversation' => $conversation->getIdconversation()]);
            }

            return $this->render('message/new.html.twig', [
                'message' => $message,
                'form' => $form->createView(),
            ]);
}
    /**
     * @Route("/{idmessage}", name="message_show", methods={"GET"})
     */
    public function show(Message $message): Response
    {
        return $this->render('message/show.html.twig', ['message' => $message]);
    }


    /**
     * @Route("/{idmessage}/edit", name="message_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Message $message): Response
    {
        $this->denyAccessUnlessGranted('MESSAGE_EDIT', $message);

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('conversation_show', ['idconversation' => $message->getConversationconversation()->getIdconversation()]);
        }

        return $this->render('message/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idmessage}", name="message_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Message $message): Response
    {
        $this->denyAccessUnlessGranted('MESSAGE_DELETE', $message);
        if ($this->isCsrfTokenValid('delete' . $message->getIdmessage(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('conversation_show', ['idconversation' => $message->getConversationconversation()->getIdconversation()]);
    }
}
