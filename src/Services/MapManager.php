<?php


namespace App\Services;


class MapManager
{
    public function tileExists(int $x, int $y):bool
    {
        //dd($x, $y);
        $result = false;
        if(0<=$x && $x<=11 && 0<=$y && $y<=5){
            $result = true;
        }
        //dd($result);
        return $result;
    }
}