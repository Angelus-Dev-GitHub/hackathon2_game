<?php


namespace App\Services;


use App\Entity\Boat;
use App\Entity\Tile;
use App\Repository\BoatRepository;
use App\Repository\TileRepository;
use phpDocumentor\Reflection\Types\True_;

class MapManager
{
    public function tileExists(int $x, int $y):bool
    {
        //J'ai pas lu entièrement l'énoncé au départ, et j'ai fais sans le TileRepository - A reprendre//
        $result = false;
        if(0<=$x && $x<=11 && 0<=$y && $y<=5){
            $result = true;
        }
        return $result;
    }


    public function getRandomIsland(TileRepository $tileRepository)
    {
        $tiles = $tileRepository->findBy(['type' => 'island']);
        $treasureIsland = $tiles[array_rand($tiles, $num = 1)];

        return $treasureIsland;
    }

    public function checkTreasure(Boat $boat, TileRepository $tileRepository)
    {
        $result = false;
        $treasureIsland = $tileRepository->findBy(['hasTreasure' => true]);
        if (($treasureIsland[0]->getCoordX() == $boat->getCoordX()) and ($treasureIsland[0]->getCoordY() == $boat->getCoordY()) ){
            return $result = true;
        }

        //dd($result);
        return $result;
    }

}