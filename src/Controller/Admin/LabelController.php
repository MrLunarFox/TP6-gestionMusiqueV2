<?php

namespace App\Controller\Admin;

use App\Entity\Label;
use App\Form\LabelType;
use App\Repository\LabelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LabelController extends AbstractController
{
    #[Route('/admin/labels', name: 'admin_labels', methods: ['GET'])]
    public function listeLabels(LabelRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $labels = $paginator->paginate(
            $repo->listeLabelComplete(),
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('admin/label/listeLabels.html.twig', [
            'lesLabels' => $labels,
        ]);
    }

    #[Route('/admin/label/ajout', name: 'admin_label_ajout', methods: ['GET', 'POST'])]
    #[Route('/admin/label/modif/{id}', name: 'admin_label_modif', methods: ['GET', 'POST'])]
    public function ajoutModifLabel(Label $label = null, Request $request, EntityManagerInterface $manager): Response
    {
        if (!$label) {
            $label = new Label(); // Initialisez une nouvelle instance de Label si $label est null
            $mode = "ajouté";
        } else {
            $mode = "modifié";
        }
    
        $form = $this->createForm(LabelType::class, $label);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($label);
            $manager->flush();
    
            $this->addFlash("success", "Le label a bien été $mode!");
    
            return $this->redirectToRoute('admin_labels');
        }
    
        return $this->render('admin/label/formAjoutModifLabel.html.twig', [
            'formLabel' => $form->createView(),
        ]);
    }

    #[Route('/admin/label/supr/{id}', name: 'admin_label_supr', methods: ['GET'])]
    public function suprLabel(Label $label, EntityManagerInterface $manager): Response
    {
        $nbAlbums = $label->getAlbums()->count();

        if ($nbAlbums > 0) {
            $this->addFlash("danger", "Vous ne pouvez pas supprimer ce label car $nbAlbums album(s) y sont associés!");
        } else {
            $manager->remove($label);
            $manager->flush();

            $this->addFlash("success", "Le label a bien été supprimé!");
        }

        return $this->redirectToRoute('admin_labels');
    }
}
