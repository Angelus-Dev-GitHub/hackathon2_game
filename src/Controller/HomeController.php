<?php

namespace App\Controller;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/start/{n}", name="start")
     */
    public function start(string $n, EntityManagerInterface $entityManager, PlayerRepository $playerRepository): Response
    {
        $playerRepository->resetPlayer();
        for ($i=1; $i<=$n; $i++) {
            $player = new Player();
            $player->setName('Joueur' . $i);
            $player->setCoordX('0');
            $player->setCoordY('0');
            $entityManager->persist($player);
        }

        $entityManager->flush();

        return $this->render('home/start.html.twig', ['players' => $playerRepository->findAll()]);
    }

    /**
     * @Route("/partyData", name="partyData")
     */
    public function partyData(): Response
    {


        return $this->redirectToRoute('map');
    }
    
    
    

}
