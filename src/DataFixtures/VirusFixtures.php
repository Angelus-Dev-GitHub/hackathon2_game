<?php

namespace App\DataFixtures;

use App\Entity\Virus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VirusFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $virus1 = new Virus();
        $virus1->setName('virus1');
        $virus1->setCoordX('5');
        $virus1->setCoordY('5');
        $virus1->setPicture('https://www.cjoint.com/doc/21_01/KAojKbXuDyX_virus.png');

        $manager->persist($virus1);

        $virus2 = new Virus();
        $virus2->setName('virus2');
        $virus2->setCoordX('9');
        $virus2->setCoordY('4');
        $virus2->setPicture('https://www.cjoint.com/doc/21_01/KAojKbXuDyX_virus.png');

        $manager->persist($virus2);

        $manager->flush();
    }
}
