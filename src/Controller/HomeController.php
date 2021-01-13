<?php

namespace App\Controller;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use App\Repository\TileRepository;
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
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/start", name="start")
     */
    public function start(MapManager $mapManager, PlayerRepository $playerRepository, TileRepository $tileRepository, EntityManagerInterface $entityManager): Response
    {
        $players = $playerRepository->findAll();
        foreach ($players as $player){
            $player->setCoordX('0');
            $player->setCoordY('0');
        }

        $tiles = $tileRepository->findAll();
        foreach ($tiles as $tile){
            $tile->setHasTreasure(false);
        }
        $entityManager->flush();

        $treasureIsland = $mapManager->getRandomIsland($tileRepository);
        $treasureIsland->setHasTreasure(true);

        $entityManager->flush();

        return $this->redirectToRoute('map');
    }

}
