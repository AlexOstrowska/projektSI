<?php
/**
 * Question fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Question;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class QuestionFixtures.
 */
class QuestionFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'questions', function ($i) {
            $Question = new Question();
            $Question->setTitle($this->faker->sentence);
            $Question->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $Question->setText($this->faker->text);
            $Question->setCategory($this->getRandomReference('categories'));


            $tags = $this->getRandomReferences(
                'tag',
                $this->faker->numberBetween(0, 5)
            );

            foreach ($tags as $tag) {
                $Question->addTag($tag);
            }

            return $Question;
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array Array of dependencies
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}