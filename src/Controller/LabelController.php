<?php

namespace App\Controller;

use App\Entity\Label;
use App\Repository\LabelRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LabelController extends AbstractController
{
    #[Route('/labels', name: 'labels', methods:['GET'])]
    public function listeLabels(LabelRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $labels = $paginator->paginate(
            $repo->listeLabelComplete(),
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('label/listeLabels.html.twig', [
            'lesLabels' => $labels,
        ]);
    }

    #[Route('/label/{id}', name: 'ficheLabel', methods:['GET'])]

    public function ficheLabel(Label $label): Response
    {
        return $this->render('label/ficheLabel.html.twig', [
            'leLabel' => $label,
        ]);
    }
}
