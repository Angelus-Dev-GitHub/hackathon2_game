<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Player;
use App\Entity\Virus;
use App\Form\GameType;
use App\Form\PlayerType;
use App\Repository\GameRepository;
use App\Repository\PictureRepository;
use App\Repository\PlayerRepository;
use App\Repository\TileRepository;
use App\Repository\VirusRepository;
use App\Services\MapManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use function Couchbase\defaultDecoder;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(VirusRepository $virusRepository, PictureRepository $pictureRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'virus' => $virusRepository->findAll(),
            'players' => $pictureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/start/{n}", name="start")
     */
    public function start(string $n,
                          EntityManagerInterface $entityManager,
                          PlayerRepository $playerRepository,
                          Request $request,
                          GameRepository $gameRepository): Response
    {
        $playerRepository->resetPlayer();
        $gameRepository->resetGame();
        $game = new Game();
        $player = new Player();
        $formPlayer = $this->createForm(PlayerType::class, $player);
        $formPlayer->handleRequest($request);
        $formGame = $this->createForm(GameType::class, $game);
        $formGame->handleRequest($request);
        if ($formGame->isSubmitted() && $formGame->isValid()) {
            $game->setNPlayer($n);
            $entityManager->persist($game);
            if ($formPlayer->isSubmitted() && $formPlayer->isValid()) {
                $player->setName($this->getUser()->getName());
                $player->setCoordY('0');
                $player->setCoordX('0');
                $player->setUser($this->getUser());
                $entityManager->persist($player);
                $entityManager->flush();

                return $this->redirectToRoute('waiting');
            }
        }

        return $this->render('home/start.html.twig', [
            'formPlayer' => $formPlayer->createView(),
            'formGame' => $formGame->createView(),
        ]);
    }

    /**
     * @Route("/joinparty", name="joinparty")
     */
    public function joinParty(Request $request, EntityManagerInterface $entityManager): Response
    {
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

            return $this->redirectToRoute('waiting');
        }

        return $this->render('home/joinParty.html.twig', [
            'formPlayer' => $formPlayer->createView(),
        ]);
    }

    /**
     * @Route("/waiting", name="waiting")
     */
    public function waiting(Request $request,
                            EntityManagerInterface $entityManager,
                            PlayerRepository $playerRepository, GameRepository $gameRepository): Response
    {

        $players = $playerRepository->findAll();
        $games = $gameRepository->findAll();


        return $this->render('home/waiting.html.twig', [
            'players' => $players,
            'games' => $games,
        ]);
    }
}
