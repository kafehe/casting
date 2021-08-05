<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Form\ActivityType;
use App\Repository\ActivityRepository;
use Doctrine\DBAL\Types\TextType;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

use function PHPUnit\Framework\throwException;

/**
 * @Route("/activity")
 */
class ActivityController extends AbstractController
{
    /**
     * @Route("/", name="activity_index", methods={"GET"})
     */
    public function index(ActivityRepository $activityRepository): Response
    {
        $activity = $this->getDoctrine()->getRepository(Activity::class);
        $activity = $activity->findAll();
        return $this->render('activity/index.html.twig', [
            'activities' => $activity,
        ]);
    }

    /**
     * @Route("/new", name="activity_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $activity = new Activity();
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activity);
            $entityManager->flush();

            return $this->redirectToRoute('activity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activity/new.html.twig', [
            'activity' => $activity,
            'form' => $form
        ]);
    }

    /**
     * @Route("/{id}", name="activity_show", methods={"GET"})
     */
    public function show(Activity $activity): Response
    {
        $act = $this->getDoctrine()->getRepository(Activity::class);
        $act = $act->find($activity);
        if (!$activity) {
            throw $this->createNotFoundException('Aucune activity pour l\'id: ' . $activity);;
        }
        return $this->render('activity/show.html.twig', [
            'activity' => $act,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="activity_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Activity $activity): Response
    {
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('activity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activity/edit.html.twig', [
            'activity' => $activity,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="activity_delete", methods={"POST"})
     */
    public function delete(Request $request, Activity $activity): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $act = $this->getDoctrine()->getRepository(Activity::class);
        $act = $act->find($activity);

        if (!$activity) {
            throw $this->createNotFoundException('there are no activity with the following id:' . $activity);
        }

        $entityManager->remove($act);
        $entityManager->flush();


        return $this->redirectToRoute('activity_index', [], Response::HTTP_SEE_OTHER);
    }
}