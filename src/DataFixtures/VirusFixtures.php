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
        $virus1->setCoordX(rand(1,11));
        $virus1->setCoordY(rand(1,5));
        $virus1->setPicture('https://www.cjoint.com/doc/21_01/KAojKbXuDyX_virus.png');

        $manager->persist($virus1);

        $virus2 = new Virus();
        $virus2->setName('virus2');
        $virus2->setCoordX(rand(1,11));
        $virus2->setCoordY(rand(1,5));
        $virus2->setPicture('https://www.cjoint.com/doc/21_01/KAojKbXuDyX_virus.png');

        $manager->persist($virus2);

        $manager->flush();
    }
}
