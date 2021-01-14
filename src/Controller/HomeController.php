<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Virus;
use App\Repository\PlayerRepository;
use App\Repository\TileRepository;
use App\Repository\VirusRepository;
use App\Services\MapManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(VirusRepository $virusRepository, PlayerRepository $playerRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'virus' => $virusRepository->findAll(),
            'players' => $playerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/start", name="start")
     */
    public function start(): Response
    {

        return $this->redirectToRoute('map');
    }

}
