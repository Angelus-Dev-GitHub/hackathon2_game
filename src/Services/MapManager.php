<?php


namespace App\Services;


use App\Entity\Player;
use App\Entity\Tile;
use App\Repository\PlayerRepository;
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

    public function checkTreasure(Player $player, TileRepository $tileRepository)
    {
        $result = false;
        $treasureIsland = $tileRepository->findBy(['hasTreasure' => true]);
        if (($treasureIsland[0]->getCoordX() == $player->getCoordX()) and ($treasureIsland[0]->getCoordY() == $player->getCoordY()) ){
            return $result = true;
        }

        //dd($result);
        return $result;
    }

}