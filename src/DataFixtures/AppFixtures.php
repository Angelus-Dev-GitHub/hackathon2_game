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
use App\Repository\PlayerRepository;
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
        $player2->setCoordX(11);
        $player2->setCoordY(0);
        $player2->setName('Thierry');
        $manager->persist($player2);

        $player3 = new Player();
        $player3->setCoordX(11);
        $player3->setCoordY(5);
        $player3->setName('Guillaume');
        $manager->persist($player3);

        $player4 = new Player();
        $player4->setCoordX(0);
        $player4->setCoordY(5);
        $player4->setName('Sandra');
        $manager->persist($player4);

        $playerSick1 = new Player();
        $playerSick1->setCoordX($player1->getCoordX());
        $playerSick1->setCoordY($player1->getCoordY());
        $playerSick1->setPicture('https://www.cjoint.com/doc/21_01/KAolql1JTwX_super-heros-malade.png');
        $manager->persist($playerSick1);

        $playerSick2 = new Player();
        $playerSick2->setCoordX($player2->getCoordX());
        $playerSick2->setCoordY($player2->getCoordY());
        $playerSick2->setPicture('https://www.cjoint.com/doc/21_01/KAolql1JTwX_super-heros-malade.png');
        $manager->persist($playerSick2);

        $playerSick3 = new Player();
        $playerSick3->setCoordX($player3->getCoordX());
        $playerSick3->setCoordY($player3->getCoordY());
        $playerSick3->setPicture('https://www.cjoint.com/doc/21_01/KAolql1JTwX_super-heros-malade.png');
        $manager->persist($playerSick3);

        $playerSick4 = new Player();
        $playerSick4->setCoordX($player4->getCoordX());
        $playerSick4->setCoordY($player4->getCoordY());
        $playerSick4->setPicture('https://www.cjoint.com/doc/21_01/KAolql1JTwX_super-heros-malade.png');
        $manager->persist($playerSick4);

        $manager->flush();
    }
}
