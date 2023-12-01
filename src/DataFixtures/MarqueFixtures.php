<?php

namespace App\DataFixtures;

use App\Entity\Marque;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MarqueFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $marques = [
            'Apple' => 'apple.svg',
            'Samsung' => 'samsung.svg',
            'Xiaomi' => 'xiaomi.svg',
            'Huawei' => 'huawei.svg',
            'Honor' => 'honor.svg',
            'Oppo' => 'oppo.svg',
            'Wiko' => 'wiko.svg',
            'Sony' => 'sony.svg',
            'Nokia' => 'nokia.svg',
            'Asus' => 'asus.svg',
        ];

        foreach ($marques as $nom => $image) {
            $marque = new Marque();
            $marque->setNom($nom);
            $marque->setImage($image);

            $this->addReference($nom, $marque);
            $manager->persist($marque);
        }

        $manager->flush();
    }
}
