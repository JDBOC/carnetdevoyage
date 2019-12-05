<?php

namespace App\DataFixtures;


use App\Entity\Etapes;
use Cocur\Slugify\Slugify;
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
        $slugify = new Slugify();

        for ($i = 0; $i <= 10; $i++) {
          $voyage = new Voyage;

          $title = $faker->sentence ();
          $slug = $slugify->slugify ( $title );
          $description = '<p>' . join ( '</p><p>' , $faker->paragraphs ( 5 ) ) . '</p>';
          $duration = mt_rand ( 3 , 21 );

          $depart = $faker->dateTimeBetween ( '-19 years' );
          $retour = (clone $depart)->modify ( "+$duration days" );

          $voyage->setTitre ( $title )
            ->setSlug ( $slug )
            ->setLieu ( $faker->country )
            ->setDescription ( $description )
            ->setDepart ( $depart )
            ->setRetour ( $retour )
            ->setCoverImage ( $faker->imageURL () );

          $manager->persist ( $voyage );

          for ($k = 0 , $kMax = mt_rand ( 3 , 10 ); $k <= $kMax; $k++) {
            $etape = new Etapes();
            $title = $faker->sentence ();
            $slug = $slugify->slugify ( $title );
            $dateEtape = $faker->dateTimeBetween ( $depart , $retour );
            $etape->setTitre ( $title )
              ->setSlug ( $slug )
              ->setLieu ( "lieu de l'étape" )
              ->setDate ( $dateEtape )
              ->setVoyage ( $voyage )
              ->setDescription ( $description );

            $manager->persist ( $etape );
          }

          for ($j = 0 , $jMax = mt_rand ( 5 , 10 ); $j <= $jMax; $j++) {
            $image = new Image;
            $image->setUrl ( $faker->imageUrl () )
              ->setCaption ( $faker->sentence () )
              ->setVoyage ( $voyage )
              ->setEtapes ( $etape );

            $manager->persist ( $image );
          }


        }

        $manager->flush();
    }
}
