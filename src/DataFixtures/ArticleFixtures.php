<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class AppFixtures.
 */
class ArticleFixtures extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(
            10,
            'article',
            function ($count) use ($manager) {
                return (new Article())->setTitle($this->faker->title);
            }
        );

       $manager->flush();
    }
}
