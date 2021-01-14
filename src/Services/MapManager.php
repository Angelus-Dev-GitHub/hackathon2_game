<?php


namespace App\Services;


use App\Entity\Player;
use App\Repository\PlayerRepository;
use App\Repository\TileRepository;
use phpDocumentor\Reflection\Types\True_;

class MapManager
{
    private $tileRepository;

    private $playerRepository;

    public function __construct(TileRepository $tileRepository,PlayerRepository $playerRepository)
    {
        $this->tileRepository = $tileRepository;
        $this->playerRepository = $playerRepository;
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

    public function SamePosition(int $x, int $y):bool
    {
        $result = true;
        $players = $this->playerRepository->findAll();
        foreach ($players as $player) {
            $w = $player->getCoordX();
            $z = $player->getCoordY();
            if (($w === $x) && ($z===$y)){
                $result = false;
            }
        }

        return $result;
    }

}