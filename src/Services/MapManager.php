<?php


namespace App\Services;


use App\Entity\Player;
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



}