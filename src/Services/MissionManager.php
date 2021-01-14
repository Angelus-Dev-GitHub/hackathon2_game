<?php


namespace App\Services;


use App\Entity\PlayerMission;
use App\Repository\MissionRepository;
use App\Repository\PlayerRepository;

class MissionManager
{
    private $missionRepository;

    private $playerRepository;

    private $gameRepository;

   public function __construct(MissionRepository $missionRepository, PlayerRepository $playerRepository)
   {
       $this->missionRepository = $missionRepository;
       $this->playerRepository = $playerRepository;
   }

   public function startMissions()
   {
       for ($i=0; $i<$this->gameRepository->)
       $missions = $this->missionRepository->findAll();
       $players = $this->playerRepository->findAll();
       $mission1 = new PlayerMission();
       $mission1->setMission($missions[rand(0, 3)]);
       $mission1->setPlayer($players[0]);

       $mission2 = new PlayerMission();
       $mission2->setMission($missions[rand(4, 6)]);
       $mission2->setPlayer($players[0]);
   }
}
