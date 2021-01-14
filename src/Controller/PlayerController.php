<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use App\Services\MapManager;
use App\Services\VirusManager;
use Doctrine\ORM\EntityManager;
use App\Services\MissionManager;
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
    public function movePlayer(int $x, int $y, PlayerRepository $playerRepository, EntityManagerInterface $em): Response
    {
        $player = $playerRepository->findOneBy([]);
        $player->setCoordX($x);
        $player->setCoordY($y);

        $em->flush();

        return $this->redirectToRoute('map');
    }

    /**
     * Move the player to direction
     * @Route("/direction/{d}/{id}", name="moveDirection")
     *
     */
    public function moveDirection(string $d,string $id,
                                  PlayerRepository $playerRepository,
                                  EntityManagerInterface $em,
                                  MapManager $mapManager, VirusManager $virusManager,
                                  MissionManager $missionManager,
                                  Player $playerr, Mission $mission): Response
    {

        $players = $playerRepository->findAll();
        $player = $playerRepository->findOneBy(['id' => $id]);
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
            $verifySamePosition = $mapManager->SamePosition($x, $y);
            if($verifySamePosition){
                $player->setCoordX($x);
                $player->setCoordY($y);
                $em->flush();
            }
            else{
                $this->addFlash('danger', 'Vous ne pouvez pas être à 2 joueurs sur une case');
            }
        }
        else{
            $this->addFlash('danger', 'Vous ne pouvez pas sortir du plateau');
        }

        $missionManager->checkMission($em);
        $virusManager->randomMoveVirus($em);
        $virusManager->isInfected($em);
        $virusManager->DesInfected($em);

        return $this->redirectToRoute('map');
    }


    /**
     * @Route("/", name="player_index", methods="GET")
     */
    public function index(PlayerRepository $playerRepository, EntityManagerInterface $entityManager): Response
    {

        return $this->render('player/index.html.twig', ['players' => $playerRepository->findAll()]);
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
    public function show(Player $player): Response
    {
        return $this->render('player/show.html.twig', ['player' => $player]);
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
