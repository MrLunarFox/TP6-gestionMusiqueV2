<?php

namespace App\Controller;

use App\Repository\NationaliteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatistiqueController extends AbstractController
{
    #[Route('/statistique', name: 'statistique')]
    public function statistiqueNationalite(NationaliteRepository $repo): Response
    {
        $nationalites = $repo->findAll();

        return $this->render('statistique/statistique.html.twig', [
            'lesNationalites' => $nationalites
        ]);
    }
}
