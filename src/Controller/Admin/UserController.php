<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Admin\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/user", name="admin_user_")*
 * @IsGranted("ROLE_ADMIN")
 */

class UserController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('admin/user/index.html.twig', ['users' => $users]);
    }
    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mdp = $encoder->encodePassword($user, $user->getPassworduser());
            $user->setPassworduser($mdp);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'L\'utilisateur a été créé avec succès.');

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{iduser}", name="show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/{iduser}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'L\'utilisateur a été modifié avec succès.');

            return $this->redirectToRoute('admin_user_show', ['iduser' => $user->getIduser()]);
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{iduser}/ban", name="ban", methods={"POST"})
     */
    public function ban(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('ban'.$user->getIduser(), $request->request->get('_token'))) {
            $user->setBanni(!$user->isBanni()).
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'L\'utilisateur a été banni.');
        }else{
            $this->addFlash('error', 'Erreur lors du bannisement de l\'utilisateur.');
        }

        return $this->redirectToRoute('admin_user_show', ['iduser' => $user->getIduser()]);
    }

    /**
     * @Route("/{iduser}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getIduser(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success', 'L\'utilisateur a été supprimé avec succès.');
        }else{
            $this->addFlash('error', 'Erreur lors de la suppression de l\'utilisateur.');
        }

        return $this->redirectToRoute('admin_user_index');
    }
}
