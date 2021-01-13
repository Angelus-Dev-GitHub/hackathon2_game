<?php


namespace App\Services;


use App\Entity\Player;
use App\Entity\Tile;
use App\Repository\PlayerRepository;
use App\Repository\TileRepository;
use phpDocumentor\Reflection\Types\True_;

class MapManager
{
    private $tileRepository;

    public function __construct(TileRepository $tileRepository)
    {
        $this->tileRepository = $tileRepository;
    }


    public function tileExists(int $x, int $y):bool
    {
        $tile = $this->tileRepository->findOneBy(['coordY' => $y, 'coordX' => $x]);
        $result = false;
        if($tile){
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