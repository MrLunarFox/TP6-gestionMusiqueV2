<?php

namespace App\tests\Functional;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NationaliteTest extends WebTestCase
{
    public function testIfCreateNationaliteIsSuccessfull(): void
    {
        $client = static::createClient();

        // Recup urlgenerator

        $urlGenerator = $client->getContainer()->get('router');

        // Recup entity manager

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $entityManager->find(User::class, 52);

        $client->loginUser($user);

        // Se rendre sur la page de création d'une nationalité

        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('admin_nationalite_ajout'));

        // Gérer le formulaire

        $form = $crawler->filter('form[name=nationalite]')->form([
            'nationalite[libelle]' => "Une nationalité",
            'nationalite[drapeau]' => "https://coloriage.info/images/ccovers/1523895214drapeau-france-italie-belgique.jpg"
        ]);

        $client->submit($form);

        // Gérer la redirection

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        // Gérer l'alert box et la route

        $this->assertRouteSame('admin_nationalites');
    }

    public function testIfListingnationaliteIsSuccessful(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get('router');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $entityManager->find(User::class, 52);

        $client->loginUser($user);

        $client->request(Request::METHOD_GET, $urlGenerator->generate('admin_nationalites'));

        $this->assertResponseIsSuccessful();

        $this->assertRouteSame('admin_nationalites');
    }
}
