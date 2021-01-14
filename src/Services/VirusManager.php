<?php


namespace App\Services;


use App\Repository\VirusRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class VirusManager
{
    private $virusRepository;

    private $mapManager;


    public function __construct(VirusRepository $virusRepository, MapManager $mapManager)
    {
        $this->virusRepository = $virusRepository;
        $this->mapManager = $mapManager;
    }

    public function randomMoveVirus($entityManager)
    {
        $virus1 = $this->virusRepository->findOneBy(['id' => 1]);
        $x1 = $virus1->getCoordX();
        $y1 = $virus1->getCoordY();

        $x1 = $x1 + rand(-1, 1);
        $y1 = $y1 + rand(-1, 1);

        $virus2 = $this->virusRepository->findOneBy(['id' => 2]);
        $x2 = $virus2->getCoordX();
        $y2 = $virus2->getCoordY();

        $x2 = $x2 + rand(-1, 1);
        $y2 = $y2 + rand(-1, 1);

        $verifyTile = $this->mapManager->tileExists($x1, $y1);
        if ($verifyTile) {
            $virus1->setCoordX($x1) || $virus1->setCoordY($y1);

            $entityManager->flush();
        }

        $verifyTile = $this->mapManager->tileExists($x2, $y2);
        if ($verifyTile) {
            $virus2->setCoordX($x2) || $virus2->setCoordY($y2);

            $entityManager->flush();
        }
    }
}
