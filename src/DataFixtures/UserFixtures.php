<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class UserFixtures.
 */
class UserFixtures extends BaseFixture
{
    const FAKE_PASSWORD = 'password';

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(
            3,
            'user',
            function ($count) {
                return (new User())
                    ->setFirstName($this->faker->name)
                    ->setEmail($this->faker->email)
                    ->setRoles(['ROLE_USER'])
                    ->setPassword(self::FAKE_PASSWORD)
                    ;
            }
        );

        $manager->flush();
    }
}
