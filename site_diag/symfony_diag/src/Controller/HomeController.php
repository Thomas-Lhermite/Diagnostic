<?php

namespace App\Controller;

use App\Repository\ActualityRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    // private $actualityRepository;

    #[Route('/', name: 'app_home', methods:"GET")]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/actualities', name: 'app_actualities', methods:"GET")]
    public function index2(ActualityRepository $actualityRepository): Response
    {
        $actualities = $actualityRepository->findAll();
        return $this->render('actuality.html.twig', [
            'actualities' => $actualities,
        ]);
    }

    #[Route('/actudesc', name: 'app_actualities_desc', methods:"GET")]
    public function index3(ActualityRepository $actualityRepository): Response
    {
        $actualities = $actualityRepository->findAll();
        return $this->render('actuality.html.twig', [
            'actualities' => $actualities,
        ]);
    }
}
