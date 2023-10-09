<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Repository\ArtisteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArtisteController extends AbstractController
{
    #[Route('/artistes', name: 'artistes', methods:['GET'])]
    public function listeArtistes(ArtisteRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $artistes = $paginator->paginate(
            $repo->listeArtisteComplete(),
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('artiste/listeArtistes.html.twig', [
            'lesArtistes' => $artistes
        ]);
    }

    #[Route('/artiste/{id}', name: 'ficheArtiste', methods:['GET'])]

    public function ficheArtiste(Artiste $artiste): Response
    {
        return $this->render('artiste/ficheArtiste.html.twig', [
            'leArtiste' => $artiste,
        ]);
    }
}