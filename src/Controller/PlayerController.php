<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use App\Repository\TileRepository;
use App\Services\MapManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/player")
 */
class PlayerController extends AbstractController
{
    const Direction = ['N','S','E','W'];

    /**
     * Move the player to coord x,y
     * @Route("/move/{x}/{y}", name="moveplayer", requirements={"x"="\d+", "y"="\d+"}))
     */
    public function moveBoat(int $x, int $y, PlayerRepository $boatRepository, EntityManagerInterface $em): Response
    {
        $boat = $boatRepository->findOneBy([]);
        $boat->setCoordX($x);
        $boat->setCoordY($y);

        $em->flush();

        return $this->redirectToRoute('map');
    }

    /**
     * Move the player to direction
     * @Route("/direction/{d}", name="moveDirection")
     *
     */
    public function moveDirection(string $d,
                                  PlayerRepository $playerRepository,
                                  EntityManagerInterface $em,
                                  MapManager $mapManager,
                                  TileRepository $tileRepository): Response
    {
        $player = $playerRepository->findOneBy([]);
        $x = $player->getCoordX();
        $y = $player->getCoordY();
        if($d === 'N'){
            $y = $y -1;
        }
        if($d === 'S'){
            $y = $y +1;
        }
        if($d === 'W'){
            $x = $x -1;
        }
        if($d === 'E'){
            $x = $x +1;
        }

        $verifyTile = $mapManager->tileExists($x, $y);
        if($verifyTile){
            $player->setCoordX($x);
            $player->setCoordY($y);
            $em->flush();
        }
        else{
            $this->addFlash('danger', 'You cannot go outside the limits of the map');
        }

        $treasure = $mapManager->checkTreasure($player, $tileRepository);
        if ($treasure){
            $this->addFlash('success', 'You find the treasure');
        }

        return $this->redirectToRoute('map');
    }


    /**
     * @Route("/", name="player_index", methods="GET")
     */
    public function index(PlayerRepository $playerRepository): Response
    {
        return $this->render('player/index.html.twig', ['boats' => $playerRepository->findAll()]);
    }

    /**
     * @Route("/new", name="player_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();

            return $this->redirectToRoute('boat_index');
        }

        return $this->render('player/new.html.twig', [
            'player' => $player,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="player_show", methods="GET")
     */
    public function show(Player $boat): Response
    {
        return $this->render('player/show.html.twig', ['player' => $boat]);
    }

    /**
     * @Route("/{id}/edit", name="player_edit", methods="GET|POST")
     */
    public function edit(Request $request, Player $player): Response
    {
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('boat_index', ['id' => $player->getId()]);
        }

        return $this->render('player/edit.html.twig', [
            'player' => $player,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="player_delete", methods="DELETE")
     */
    public function delete(Request $request, Player $player): Response
    {
        if ($this->isCsrfTokenValid('delete' . $player->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($player);
            $em->flush();
        }

        return $this->redirectToRoute('player_index');
    }
}
