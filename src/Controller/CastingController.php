<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Casting;
use Symfony\Component\Form\FormTypeInterface;
use App\Controller\JsonResponse;
use App\Entity\Document;
use App\Form\CastingType;
use App\Form\FilesType;
use App\Repository\CastingRepository;
use Doctrine\DBAL\Types\TextType;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse as HttpFoundationJsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/casting")
 */
class CastingController extends AbstractController
{
    /**
     * @Route("/", name="casting_index", methods={"GET"})
     */
    public function index(CastingRepository $castingRepository): Response
    {
        $casting = $this->getDoctrine()->getRepository(Casting::class);
        $casting = $casting->findAll();
        return $this->render('casting/index.html.twig', [
            'castings' => $casting
        ]);
    }

    /**
     * @Route("/new", name="casting_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $casting = new Casting();
        $form = $this->createForm(CastingType::class, $casting);
        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            //dd($form->get('images')->getData(), $form->get('documentsTodo')->getData());
            //dd($form->get('documentsTodo')->getData());

            // On récupère les images et docs transmis
            $uploadedFile = $form->get('images')->getData();
            $uploadedFiles = $form->get('documentsTodo')->getData();

            //dd($uploadedFile, $uploadedFiles);
            // On boucle sur les images

            foreach ($uploadedFile as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // on recupere le type de l'image
                $originalname = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
                // on recupere le nom de l'image
                $originalname1 = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);


                //dd($originalname, $originalname1);
                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $file = new File();
                $file->setName($originalname1);
                $file->setType($originalname);
                $file->setFilename($fichier);
                // On crée l'image dans la base de données

                $casting->addImage($file);

                $entityManager->persist($file);
                $entityManager->persist($casting);
            }

            // On boucle sur les docs 
            foreach ($uploadedFiles as $doc) {
                $document = md5(uniqid()) . '.' . $doc->guessExtension();

                $originalname = pathinfo($doc->getClientOriginalName(), PATHINFO_EXTENSION);
                $originalname1 = pathinfo($doc->getClientOriginalName(), PATHINFO_FILENAME);

                $doc->move(
                    $this->getParameter('documents_directory'),
                    $document
                );
                $dcmt = new Document();
                $dcmt->setNameDoc($originalname1);
                $dcmt->setTypeDoc($originalname);
                $dcmt->setPath($document);

                // On crée l'image dans la base de données

                $casting->addDocumentsTodo($dcmt);

                $entityManager->persist($dcmt);
                $entityManager->persist($casting);
            }

            $entityManager->persist($casting);
            $entityManager->flush();

            return $this->redirectToRoute('casting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('casting/new.html.twig', [
            'form' => $form,
            'casting' => $casting,
        ]);
    }

    /**
     * @Route("/{id}", name="casting_show", methods={"GET"})
     */
    public function show(Casting $casting): Response
    {
        $cast = $this->getDoctrine()->getRepository(Casting::class);
        $cast = $cast->find($casting);
        if (!$casting) {
            throw $this->createNotFoundException('Aucun casting pour l\'id: ' . $casting);
        }
        return $this->render('casting/show.html.twig', [
            'casting' => $cast,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="casting_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Casting $casting): Response
    {
        $form = $this->createForm(CastingType::class, $casting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises


            // On boucle sur les images

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($casting);
            $entityManager->flush();

            return $this->redirectToRoute('casting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('casting/edit.html.twig', [
            'casting' => $casting,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="casting_delete", methods={"POST"})
     */
    public function delete(Request $request, Casting $casting): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cast = $this->getDoctrine()->getRepository(Casting::class);
        $cast = $cast->find($casting);

        if (!$casting) {
            throw $this->createNotFoundException('there are no casting with the following id:' . $casting);
        }
        $entityManager->remove($cast);
        $entityManager->flush();


        return $this->redirectToRoute('casting_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/supprime/image/{id}", name="casting_delete_image", methods={"DELETE"})
     */
    public function deleteImage(File $image, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $data['_token'])) {
            // On récupère le nom de l'image
            $nom = $image->getName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory') . '/' . $nom);

            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // On répond en json
            return new HttpFoundationJsonResponse(['success' => 1]);
        } else {
            return new HttpFoundationJsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}