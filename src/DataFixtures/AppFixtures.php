<?php

/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 23/11/18
 * Time: 11:29
 */

namespace App\DataFixtures;

use App\Entity\Player;
use App\Entity\Tile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tiles = [
            ['sea', 'sea', 'sea', 'sea', 'sea', 'island', 'sea', 'sea', 'sea', 'port', 'sea', 'sea'],
            ['sea', 'port', 'sea', 'island', 'sea', 'sea', 'sea', 'sea', 'sea', 'sea', 'island', 'sea'],
            ['sea', 'sea', 'sea', 'sea', 'sea', 'sea', 'sea', 'sea', 'island', 'sea', 'sea', 'sea'],
            ['sea', 'island', 'sea', 'sea', 'island', 'sea', 'sea', 'sea', 'sea', 'sea', 'sea', 'sea'],
            ['sea', 'sea', 'sea', 'sea', 'sea', 'sea', 'sea', 'island', 'sea', 'sea', 'port', 'sea'],
            ['island', 'sea', 'sea', 'sea', 'port', 'sea', 'sea', 'sea', 'sea', 'sea', 'sea', 'island'],
        ];

        foreach ($tiles as $y => $line) {
            foreach ($line as $x => $type) {
                $tile = new Tile();
                $tile->setType($type);
                $tile->setCoordX($x);
                $tile->setCoordY($y);
                $manager->persist($tile);
            }
        }

        $player1 = new Player();
        $player1->setCoordX(0);
        $player1->setCoordY(0);
        $player1->setName('Edwige');
        $manager->persist($player1);

        $player2 = new Player();
        $player2->setCoordX(0);
        $player2->setCoordY(1);
        $player2->setName('Thierry');
        $manager->persist($player2);

        $player3 = new Player();
        $player3->setCoordX(0);
        $player3->setCoordY(2);
        $player3->setName('Guillaume');
        $manager->persist($player3);

        $player4 = new Player();
        $player4->setCoordX(0);
        $player4->setCoordY(3);
        $player4->setName('Sandra');
        $manager->persist($player4);

        $manager->flush();
    }
}
