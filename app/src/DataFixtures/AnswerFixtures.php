<?php
/**
 * Answer fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Answer;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class AnswerFixtures
 */
class AnswerFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     */
    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(20, 'answer', function ($i){
            $answer = new Answer();
            $answer->setName($this->faker->firstName);
            $answer->setText($this->faker->sentence);
            $answer->setEmail(sprintf('user%d@example.com', $i));
            $answer->setQuestion($this->getRandomReference('questions'));
            $answer->setFavourite(sprintf('0', $i));
            return $answer;
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
        return [
            QuestionFixtures::class,

        ];
    }
}
