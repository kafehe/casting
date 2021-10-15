<?php

namespace App\Controller;

use ApiPlatform\Core\GraphQl\Type\Definition\UploadType;
use App\Entity\File;
use App\Form\FilesType;
use App\Repository\FileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/file")
 */
class FileController extends AbstractController
{
    /**
     * @Route("/", name="file_index", methods={"GET"})
     */
    public function index(FileRepository $fileRepository): Response
    {
        $file = $this->getDoctrine()->getRepository(File::class);
        $file = $file->findAll();
        return $this->render('file/index.html.twig', [
            'files' => $file,
        ]);
    }

    /**
     * @Route("/new", name="file_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $file = new File();
        $form = $this->createForm(FilesType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['imageFile']->getData();

            $destination = $this->getParameter('images_directory');

            $newFilename = md5(uniqid()) . '.' . $uploadedFile->guessExtension();

            $uploadedFile->move(
                $destination,
                $newFilename
            );

            $file->setLink($newFilename);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($file);
            $entityManager->flush();

            return $this->redirectToRoute('file_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('file/new.html.twig', [
            'file' => $file,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="file_show", methods={"GET"})
     */
    public function show(File $file): Response
    {
        $files = $this->getDoctrine()->getRepository(File::class);
        $files = $files->find($file);
        if (!$file) {
            throw $this->createNotFoundException('Aucun document pour l\'id: ' . $file);;
        }
        return $this->render('file/show.html.twig', [
            'file' => $files,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="file_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, File $file): Response
    {
        $form = $this->createForm(FilesType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('file_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('file/edit.html.twig', [
            'file' => $file,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="file_delete", methods={"POST"})
     */
    public function delete(Request $request, File $file): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $files = $this->getDoctrine()->getRepository(File::class);
        $files = $files->find($file);

        if (!$file) {
            throw $this->createNotFoundException('there are no file with the following id:' . $file);
        }

        $entityManager->remove($file);
        $entityManager->flush();

        return $this->redirectToRoute('file_index', [], Response::HTTP_SEE_OTHER);
    }
}
