<?php

namespace App\Controller;

use App\Entity\Boat;
use App\Repository\BoatRepository;
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
    public function start(MapManager $mapManager,BoatRepository $boatRepository,TileRepository $tileRepository, EntityManagerInterface $entityManager): Response
    {
        $boats = $boatRepository->findAll();
        foreach ($boats as $boat){
            $boat->setCoordX('0');
            $boat->setCoordY('0');
        }

        $tiles = $tileRepository->findAll();
        foreach ($tiles as $tile){
            $tile->setHasTreasure(false);
        }
        $entityManager->flush();

        $treasureIsland = $mapManager->getRandomIsland($tileRepository);
        $treasureIsland->setHasTreasure(true);

        //dd($boat, $treasureIsland);
        $entityManager->flush();

        return $this->redirectToRoute('map');
    }

}
