<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\House;
use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class HouseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker=Factory::create()  ;

        for ($i=1; $i<25;$i++){


            $location = new Location();
            $location->setVille("Ville $i");
            $manager->persist($location);
        
            for ($j=1;$j<=2;$j++) {
                $house = new House();
                $house->setTitle($faker->name)
                ->setNightPrice($faker->number)
                ->setRoom(3)
                ->setPerson(6)
                ->setDescription("Villa à Monastir S+5 ....... 2 salle de bains ... 3 toilettes")
                ->setLocation($location);
                
                $manager->persist($house);
            }

            for ($k=0; $k <= mt_rand(4,6); $k++){
                $comment = new Comment();
                $comment->setContent("textttt sfergeg kkzfjmkj lkzngflksfg lkgjflsfng lzijfzm lzfhgzlgi")
                ->setCeatedAt($faker->dateTime)
                ->setHouse($house);
            $manager->persist($comment);



            }
        
        $manager->flush();
    }
}
}