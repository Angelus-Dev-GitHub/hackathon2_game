<?php


namespace App\Services;


use App\Entity\Tile;
use App\Repository\TileRepository;

class MapManager
{
    public function tileExists(int $x, int $y):bool
    {
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

}