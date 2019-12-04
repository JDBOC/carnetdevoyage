<?php

namespace App\DataFixtures;


use Faker\Factory;
use App\Entity\Image;
use App\Entity\Voyage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR - fr');


        for ($i = 0; $i <= 10; $i++) {
            $voyage = new Voyage;

            $title = $faker->sentence();

            $description = '<p>' . join('</p><p>', $faker->paragraphs(4)) . '</p>';

            $duration = mt_rand(3, 21);

            $depart = $faker->dateTimeBetween('-19 years');
            $retour = (clone $depart)->modify("+$duration days");

            $voyage ->setTitre($title)
                    ->setLieu($faker->country)
                    ->setDescription($description)
                    ->setDepart($depart)
                    ->setRetour($retour)
                    ->setCoverImage($faker->imageURL());

            for ($j = 0 , $jMax = mt_rand ( 5 , 10 ); $j <= $jMax; $j++) {
                $image = new Image;
                $image  ->setUrl($faker->imageUrl())
                        ->setCaption($faker->sentence())
                        ->setVoyage($voyage);

                $manager->persist($image);
            }

            $manager->persist($voyage);
        }

        $manager->flush();
    }
}
