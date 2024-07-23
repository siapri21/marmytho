<?php

namespace App\DataFixtures;

use App\Entity\Recette;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class RecetteFixtures extends Fixture
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($faker));
        for ($i = 0; $i < 50; $i++) {
            $product = new Recette();
            $product->setName($faker->vegetableName());
            $product->setPrice(45);
            $product->setDescription($faker->paragraph());
            $product->setDifficulte($faker->numberBetween(1, 5));
            $product->setNmbrePerson($faker->numberBetween(1, 50));
            $product->setCreateAt(new DateTimeImmutable());

            
            // Générer le slug à partir du nom
            $slug = $this->slugger->slug('nom')->lower();
            $product->setSlug($slug);

             // Définir createAt et updateAt
             $createAt = $faker->dateTimeBetween('-1 year', 'now');
             $product->setCreateAt(\DateTimeImmutable::createFromMutable($createAt));
             
             $updateAt = $faker->dateTimeBetween($createAt, 'now');
             $product->setUpdateAt(\DateTimeImmutable::createFromMutable($updateAt));
 


            $manager->persist($product);
        }
      

        $manager->flush();
    }
}
