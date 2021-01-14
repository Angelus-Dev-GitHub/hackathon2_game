<?php

namespace App\Controller;

use App\Repository\PictureRepository;
use App\Repository\TileRepository;
use App\Repository\VirusRepository;
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
    public function displayMap(PlayerRepository $playerRepository,
                               TileRepository $tileRepository,
                               VirusRepository $virusRepository,
                                PictureRepository $pictureRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $tiles = $em->getRepository(Tile::class)->findAll();

        foreach ($tiles as $tile) {
            $map[$tile->getCoordX()][$tile->getCoordY()] = $tile;
        }

        $players = $playerRepository-> findAll();
        $virus = $virusRepository->findAll();
        $pictures = $pictureRepository->findAll();


        return $this->render('map/index.html.twig', [
            'map'  => $map ?? [],
            'players' => $players,
            'tiles' => $tiles,
            'virus' => $virus,
            'pictures' => $pictures,
        ]);
    }
}
