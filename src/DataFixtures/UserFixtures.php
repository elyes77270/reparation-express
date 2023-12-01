<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user->setUsername('elyes77');
        $user->setPassword('$2y$13$CwWbnBTSaU3gC.oXksglQOnpnGnWHKWbytV9S39DRMyvAa4/YFQti');
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        $manager->flush();
    }
}
