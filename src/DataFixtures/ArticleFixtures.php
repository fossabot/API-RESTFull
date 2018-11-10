<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class AppFixtures.
 */
class ArticleFixtures extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(
            10,
            'article',
            function ($count) {
                return (new Article())
                    ->setTitle($this->faker->title)
                    ->setAuthor($this->getRandomReference('user'))
                    ;
            }
        );

       $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
