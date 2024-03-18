<?php

namespace App\Controller;

use App\Repository\NationaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatistiqueController extends AbstractController
{
    #[Route('/statistique', name: 'statistique')]
    public function statistiqueNationalite(NationaliteRepository $nationaliteRepository): Response
    {
        $lesNationalites = $nationaliteRepository->listeNationaliteComplete()->getResult();

        return $this->render('statistique/statistique.html.twig', [
            'lesNationalites' => $lesNationalites,
        ]);
    }
}