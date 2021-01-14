<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PictureFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $picture1 = new Picture();
        $picture1->setName('Black Panther');
        $picture1->setLink('https://www.cjoint.com/doc/21_01/KAnsl5SjAgX_black-panther.png');
        $manager->persist($picture1);

        $picture2 = new Picture();
        $picture2->setName('Captain America');
        $picture2->setLink('https://www.cjoint.com/doc/21_01/KAnsgmhE1lX_captain-america.png');
        $manager->persist($picture2);

        $picture3 = new Picture();
        $picture3->setName('Wonder Woman');
        $picture3->setLink('https://www.cjoint.com/doc/21_01/KAnsoDXlRoX_wonder-woman.png');
        $manager->persist($picture3);

        $picture4 = new Picture();
        $picture4->setName('Batman');
        $picture4->setLink('https://www.cjoint.com/doc/21_01/KAnsryAVKXX_batman.png');
        $manager->persist($picture4);

        $manager->flush();
    }
}
