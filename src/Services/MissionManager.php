<?php


namespace App\Services;



use App\Entity\PlayerMission;
use App\Repository\GameRepository;
use App\Repository\MissionRepository;
use App\Repository\PlayerMissionRepository;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;

class MissionManager
{
    private $missionRepository;

    private $playerRepository;

    private $gameRepository;

    private $playerMissionRepository;

    const SAFE = [['2','5'],['5','5'],['7','5'],['9','5']];

   public function __construct(MissionRepository $missionRepository, PlayerRepository $playerRepository,
                               GameRepository $gameRepository, PlayerMissionRepository $playerMissionRepository)
   {
       $this->missionRepository = $missionRepository;
       $this->playerRepository = $playerRepository;
       $this->gameRepository = $gameRepository;
       $this->playerMissionRepository = $playerMissionRepository;
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

   public function checkMission(EntityManagerInterface $entityManager)
   {
       $missions = $this->missionRepository->findAll();
       $players = $this->playerRepository->findAll();
       $result = false;
       foreach ($missions as $mission){
           $x = $mission->getCoordX();
           $y = $mission->getCoordY();
           foreach ($players as $player){
               $w = $player->getCoordX();
               $z = $player->getCoordY();
               if ($x == $w && $y == $z){
                   $missionValid = $this->playerMissionRepository->findOneBy(['player' => $player->getId(), 'mission' => $mission->getId()]);
                   if ($missionValid){
                       $missionValid->setIsValid(true);
                       $result = true;
                   }

               }
           }
       }
       $entityManager->flush();
       return $result;
   }

    public function checkWin()
    {
        $result = false;
        $players = $this->playerRepository->findAll();

        foreach ($players as $player){
            $count = 0;
            $playermissions = $this->playerMissionRepository->findBy(['player' => $player->getId()]);
            foreach ($playermissions as $playermission){
                if ($playermission->getIsValid() === true){
                    $count++;
                }
            }
            if ($count === 2){
                foreach (self::SAFE as $safe){
                    $x = $safe[0];
                    $y = $safe[1];
                        if ($x == $player->getCoordX() && $y == $player->getCoordY()){
                            $result = true;
                        }
                }
            }
        }
        return $result;
    }

}
