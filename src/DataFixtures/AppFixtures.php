<?php

namespace App\DataFixtures;


use Faker\Factory;
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
                    ->setSlug("titre-du-voyage-n-$i")
                    ->setLieu($faker->country)
                    ->setDescription($description)
                    ->setDepart($depart)
                    ->setRetour($retour);
            $manager->persist($voyage);
        }
        $manager->flush();
    }
}
