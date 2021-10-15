<?php

namespace App\Controller;

use App\Entity\Roleplay;
use App\Form\RoleplayType;
use App\Repository\RoleplayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/roleplay")
 */
class RoleplayController extends AbstractController
{
    /**
     * @Route("/", name="roleplay_index", methods={"GET"})
     */
    public function index(RoleplayRepository $roleplayRepository): Response
    {
        $role = $this->getDoctrine()->getRepository(Roleplay::class);
        $role = $role->findAll();
        return $this->render('roleplay/index.html.twig', [
            'roleplays' => $role,
        ]);
    }

    /**
     * @Route("/new", name="roleplay_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $roleplay = new Roleplay();
        $form = $this->createForm(RoleplayType::class, $roleplay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($roleplay);
            $entityManager->flush();

            return $this->redirectToRoute('roleplay_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('roleplay/new.html.twig', [
            'roleplay' => $roleplay,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="roleplay_show", methods={"GET"})
     */
    public function show(Roleplay $roleplay): Response
    {
        return $this->render('roleplay/show.html.twig', [
            'roleplay' => $roleplay,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="roleplay_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Roleplay $roleplay): Response
    {
        $form = $this->createForm(RoleplayType::class, $roleplay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('roleplay_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('roleplay/edit.html.twig', [
            'roleplay' => $roleplay,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="roleplay_delete", methods={"POST"})
     */
    public function delete(Request $request, Roleplay $roleplay): Response
    {
        if ($this->isCsrfTokenValid('delete' . $roleplay->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($roleplay);
            $entityManager->flush();
        }

        return $this->redirectToRoute('roleplay_index', [], Response::HTTP_SEE_OTHER);
    }
}