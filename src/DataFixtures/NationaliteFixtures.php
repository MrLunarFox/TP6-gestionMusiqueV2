<?php

namespace App\DataFixtures;

use App\Entity\Nationalite;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class NationaliteFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $file = fopen(__DIR__ . '/nationalite.csv', 'r');

        while (($row = fgetcsv($file)) !== FALSE) {
            $nationalite = new Nationalite();
            $nationalite->setLibelle($row[1]);
            $nationalite->setDrapeau($row[2]);

            $manager->persist($nationalite);
        }

        fclose($file);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 1;
    }
}