<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class IngredientFixtures extends Fixture
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager): void
    {

         

        $faker = \Faker\Factory::create();

        $faker->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($faker));
        for ($i = 0; $i < 50; $i++) {

            $product = new Ingredient();
            $product->setName($faker->vegetableName());

            $slug = $this->slugger->slug($product->getName())->lower();
            $product->setSlug($slug);

            $product->setPrice($faker->randomFloat(1,1,100));
            $product->setCreateAt(new DateTimeImmutable());
            $manager->persist($product);
            $this->addReference('INGREDIENT' . $i, $product);
        }
        $manager->flush();
    }
}
