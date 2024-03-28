<?php

namespace App\Controller\Admin;

use App\Entity\Nationalite;
use App\Form\NationaliteType;
use App\Form\FiltreNationaliteType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\NationaliteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NationaliteController extends AbstractController
{
    #[Route('/admin/nationalite', name: 'admin_nationalites', methods:['GET'])]
    public function listeNationalite(NationaliteRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $libelle = null;
        $formFiltreNationalite = $this->createForm(FiltreNationaliteType::class);
        $formFiltreNationalite->handleRequest($request);

        if($formFiltreNationalite->isSubmitted() && $formFiltreNationalite->isValid())
        {
            $libelle = $formFiltreNationalite->get('libelle')->getData();
        }

        $nationalites = $paginator->paginate(
            $repo->listeNationaliteCompleteAdmin($libelle),
             $request->query->getInt('page', 1),
            9
        );
    
        return $this->render('admin/nationalite/listeNationalite.html.twig', [
            'lesNationalites' => $nationalites,
            'formFiltreNationalite' => $formFiltreNationalite->createView()
        ]);
    }

    #[Route('/admin/nationalite/ajout', name: 'admin_nationalite_ajout', methods:['GET', 'POST'])]
    #[Route('/admin/nationalite/modif/{id}', name: 'admin_nationalite_modif', methods:['GET', 'POST'])]
    public function ajoutModifNationalite(Nationalite $nationalite = null, Request $request, EntityManagerInterface $manager): Response
    {
        if($nationalite == null) {
            $nationalite = new Nationalite();
            $mode = "ajouté";
        } else {
            $mode = "modifié";
        }

        $form = $this->createForm(NationaliteType::class, $nationalite);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $manager->persist($nationalite);
            $manager->flush();

            $this->addFlash("success", "La nationalité a bien été $mode!");

            return $this->redirectToRoute('admin_nationalites');
        }

        return $this->render('admin/nationalite/formAjoutModifNationalite.html.twig', [
            'formNationalite' => $form->createView()
        ]);
    }

    #[Route('/admin/nationalite/supr/{id}', name: 'admin_nationalite_supr', methods:['GET'])]
    public function suprNationalite(Nationalite $nationalite, EntityManagerInterface $manager): Response
    {
        // $nbArtistes = $nationalite->getArtistes()->count();

        // if($nbArtistes > 0) {
        //     $this->addFlash("danger", "Vous ne pouvez pas supprimer cette nationalite car $nbArtistes artiste(s) y sont associés!");
        // } else {
        //     $manager->remove($nationalite);
        //     $manager->flush();

        //     $this->addFlash("success", "La nationalite a bien été supprimé!");
        // }

        $manager->remove($nationalite);
            $manager->flush();

            $this->addFlash("success", "La nationalite a bien été supprimé!");

        return $this->redirectToRoute('admin_nationalites');
    }
}
