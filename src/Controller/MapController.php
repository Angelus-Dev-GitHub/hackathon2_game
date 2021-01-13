<?php

namespace App\Controller;

use App\Repository\TileRepository;
use App\Services\MapManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tile;
use App\Repository\PlayerRepository;

class MapController extends AbstractController
{
    /**
     * @Route("/map", name="map")
     */
    public function displayMap(PlayerRepository $playerRepository, TileRepository $tileRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $tiles = $em->getRepository(Tile::class)->findAll();

        foreach ($tiles as $tile) {
            $map[$tile->getCoordX()][$tile->getCoordY()] = $tile;
        }

        $players = $playerRepository-> findAll();

        return $this->render('map/index.html.twig', [
            'map'  => $map ?? [],
            'players' => $players,
            'tiles' => $tiles,
        ]);
    }
}
