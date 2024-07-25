<?php

namespace App\DataFixtures;

use App\Entity\Recette;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class RecetteFixtures extends Fixture  implements DependentFixtureInterface
{
    private $faker;
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
        $this->faker = Factory::create();
    }
    public function load(ObjectManager $manager): void
    {
        $this->faker->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($this->faker));

        for ($i = 0; $i < 8; $i++) {
            $recipe = new Recette();
            $recipe->setName($this->faker->unique->foodName());
            $recipe->setSlug($this->slugger->slug($recipe->getName())->lower());
            $recipe->setTemps($this->faker->numberBetween(10, 300));
            $recipe->setPersonnes($this->faker->numberBetween(1, 50));
            $recipe->setDifficulty($this->faker->numberBetween(1, 6));
            $recipe->setDescription($this->faker->realText(200, 2));
            $recipe->setPrice($this->faker->randomFloat(2, 0, 100));
            $recipe->setFavorite($this->faker->boolean());

            for ($j = 0; $j < mt_rand(1, 6); $j++) {
                $recipe->addIngredient($this->getReference('INGREDIENT' . mt_rand(0, 19)));
            }
            $manager->persist($recipe);
        }

        $manager->flush();
    }


    public function getDependencies()
    {
        return [IngredientFixtures::class];
    }
}