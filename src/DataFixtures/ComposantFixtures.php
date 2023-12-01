<?php

namespace App\DataFixtures;

use App\Entity\Composant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ComposantFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $components = [
            'Remplacement haut parleur',
            'Diagnostic',
            'Remplacement caméra avant',
            'Réparation écran',
            'Désoxydation',
            'Remplacement bouton home',
            'Écouteurs',
            'Mise à jour logiciel',
            'Remplacement micro',
            'Remplacement vibreur',
            'Remplacement batterie',
            'Remplacement connecteur de charge',
            'Remplacement bouton volume',
            'Remplacement bouton On/Off',
            'Remplacement caméra arrière',
        ];

        foreach ($components as $componentName) {
            $composant = new Composant();
            $composant->setNom($componentName);
            $manager->persist($composant);
        }

        $manager->flush();
    }
}
