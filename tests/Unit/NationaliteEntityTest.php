<?php

namespace App\Tests\Unit;

use App\Entity\Nationalite;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NationaliteEntityTest extends KernelTestCase
{
    public function getEntity(): Nationalite
    {
        return (new Nationalite())
            ->setLibelle('Nationalite #1')
            ->setDrapeau('https://coloriage.info/images/ccovers/1523895214drapeau-france-italie-belgique.jpg')
        ;
    }

    public function testEntityIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $nationalite = $this->getEntity();

        $errors = $container->get('validator')->validate($nationalite);

        $this->assertCount(0, $errors);
    }

    public function testInvalidLibelle(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $nationalite = $this->getEntity();
        $nationalite->setLibelle('');

        $errors = $container->get('validator')->validate($nationalite);

        $this->assertCount(2, $errors);
    }
}
