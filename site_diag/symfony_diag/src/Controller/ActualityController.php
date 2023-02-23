<?php

namespace App\Controller;

use App\Entity\Actuality;
use App\Form\ActualityType;
use App\Repository\ActualityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Route('/actuality')]
class ActualityController extends AbstractController
{
    #[Route('/', name: 'app_actuality_index', methods: ['GET'])]
    public function index(ActualityRepository $actualityRepository): Response
    {
        return $this->render('actuality/index.html.twig', [
            'actualities' => $actualityRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_actuality_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ActualityRepository $actualityRepository, sluggerInterface $slugger): Response
    {
        $actuality = new Actuality();
        $form = $this->createForm(ActualityType::class, $actuality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                /** @var UploadedFile $brochureFile */
                $brochureFile = $form->get('brochure')->getData();
    
                // this condition is needed because the 'brochure' field is not required
                // so the PDF file must be processed only when a file is uploaded
                if ($brochureFile) {
                    $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();
    
                    // Move the file to the directory where brochures are stored
                    try {
                        $brochureFile->move(
                            $this->getParameter('brochures_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
    
                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $actuality->setBrochureFilename($newFilename);
                }
    
                // ... persist the $actuality variable or any other work
    

            $actualityRepository->save($actuality, true);

            return $this->redirectToRoute('app_actuality_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actuality/new.html.twig', [
            'actuality' => $actuality,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_actuality_show', methods: ['GET'])]
    public function show(Actuality $actuality): Response
    {
        return $this->render('actuality/show.html.twig', [
            'actuality' => $actuality,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_actuality_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Actuality $actuality, ActualityRepository $actualityRepository): Response
    {
        $form = $this->createForm(ActualityType::class, $actuality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actualityRepository->save($actuality, true);

            return $this->redirectToRoute('app_actuality_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actuality/edit.html.twig', [
            'actuality' => $actuality,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_actuality_delete', methods: ['POST'])]
    public function delete(Request $request, Actuality $actuality, ActualityRepository $actualityRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actuality->getId(), $request->request->get('_token'))) {
            $actualityRepository->remove($actuality, true);
        }

        return $this->redirectToRoute('app_actuality_index', [], Response::HTTP_SEE_OTHER);
    }
}
