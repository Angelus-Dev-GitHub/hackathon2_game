<?php


namespace App\Services;


use App\Entity\PlayerMission;
use App\Repository\GameRepository;
use App\Repository\MissionRepository;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class MissionManager
{
    private $missionRepository;

    private $playerRepository;

    private $gameRepository;

   public function __construct(MissionRepository $missionRepository, PlayerRepository $playerRepository,
                               GameRepository $gameRepository)
   {
       $this->missionRepository = $missionRepository;
       $this->playerRepository = $playerRepository;
       $this->gameRepository = $gameRepository;
   }

   public function startMissions(EntityManagerInterface $entityManager)
   {
       $maxAll = $this->gameRepository->findAll();
       $max = $maxAll[0]->getNPlayer();
       for ($i=0; $i<$max; $i++) {
           $missions = $this->missionRepository->findAll();
           $players = $this->playerRepository->findAll();
           $mission1 = new PlayerMission();
           $mission1->setMission($missions[rand(0, 3)]);
           $mission1->setPlayer($players[$i]);
           $mission1->setIsValid(false);
           $mission2 = new PlayerMission();
           $mission2->setMission($missions[rand(4, 6)]);
           $mission2->setPlayer($players[$i]);
           $mission2->setIsValid(false);
           $entityManager->persist($mission1);
           $entityManager->persist($mission2);
       }
       $entityManager->flush();

   }
}
