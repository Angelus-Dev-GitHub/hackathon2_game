<?php

namespace App\Controller;

use App\Repository\TileRepository;
use App\Services\MapManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/start", name="start")
     */
    public function start(MapManager $mapManager, TileRepository $tileRepository): Response
    {
        $mapManager->getRandomIsland($tileRepository);


        return $this->redirectToRoute('map');
    }

}
