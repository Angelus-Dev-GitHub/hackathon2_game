<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
    public function start(string $n, EntityManagerInterface $entityManager, PlayerRepository $playerRepository, Request $request): Response
    {
        $playerRepository->resetPlayer();
        $player = new Player();
        $formPlayer = $this->createForm(PlayerType::class, $player);
        $formPlayer->handleRequest($request);
        if ($formPlayer->isSubmitted() && $formPlayer->isValid()) {
            $player->setName($this->getUser()->getName());
            $player->setCoordY('0');
            $player->setCoordX('0');
            $player->setUser($this->getUser());
            $entityManager->persist($player);
            $entityManager->flush();

            return $this->redirectToRoute('map');
        }

        return $this->render('home/start.html.twig', [
            'formPlayer' => $formPlayer->createView(),
        ]);
    }

    /**
     * @Route("/joinparty", name="joinparty")
     */
    public function partyData(): Response
    {


        return $this->render('home/start.html.twig');
    }

}
