<?php

namespace App\DataFixtures;

use App\Entity\Mission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MissionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $mission1 = new Mission();
        $mission1->setName('Cinéma');
        $mission1->setCoordX(1);
        $mission1->setCoordY(3);
        $manager->persist($mission1);


        $mission3 = new Mission();
        $mission3->setName('Musées');
        $mission3->setCoordX(5);
        $mission3->setCoordY(0);
        $manager->persist($mission3);

        $mission4 = new Mission();
        $mission4->setName('Bibliothèque');
        $mission4->setCoordX(6);
        $mission4->setCoordY(2);
        $manager->persist($mission4);

        $mission5 = new Mission();
        $mission5->setName('Magasins');
        $mission5->setCoordX(9);
        $mission5->setCoordY(1);
        $manager->persist($mission5);

        $mission6 = new Mission();
        $mission6->setName('Sport');
        $mission6->setCoordX(8);
        $mission6->setCoordY(3);
        $manager->persist($mission6);

        $mission7 = new Mission();
        $mission7->setName('Restaurant');
        $mission7->setCoordX(4);
        $mission7->setCoordY(4);
        $manager->persist($mission7);

        $mission8 = new Mission();
        $mission8->setName('Concert');
        $mission8->setCoordX(10);
        $mission8->setCoordY(4);
        $manager->persist($mission8);

        $manager->flush();
    }
}
