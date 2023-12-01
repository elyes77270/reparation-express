<?php

namespace App\DataFixtures;

use App\Entity\Composant;
use App\Entity\ComposantTelephone;
use App\Entity\Telephone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ComposantTelephoneFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            ComposantFixtures::class,
            TelephoneFixtures::class,
        ];
    }

    public function load(ObjectManager $manager)
    {
        $telephones = $manager->getRepository(Telephone::class)->findAll();
        $composants = $manager->getRepository(Composant::class)->findAll();

        foreach ($telephones as $telephone) {
            foreach ($composants as $composant) {
                $composantTelephone = new ComposantTelephone();
                $composantTelephone->setTelephone($telephone);
                $composantTelephone->setComposant($composant);
                $composantTelephone->setPrix(100); // Prix de 100€ pour chaque composant

                $manager->persist($composantTelephone);
            }
        }

        $manager->flush();
    }
}

