<?php

namespace App\Controller\Admin;


use App\Entity\Album;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AlbumController extends AbstractController
{
    #[Route('/admin/albums', name: 'admin_albums', methods:['GET'])]
    public function listeAlbums(AlbumRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $albums = $paginator->paginate(
            $repo->listeAlbumCompleteAdmin(),
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('admin/album/listeAlbums.html.twig', [
            'lesAlbums' => $albums
        ]);
    }

    #[Route('/admin/album/ajout', name: 'admin_album_ajout', methods:['GET', 'POST'])]
    #[Route('/admin/album/modif/{id}', name: 'admin_album_modif', methods:['GET', 'POST'])]
    public function ajoutModifAlbum(Album $album = null, Request $request, EntityManagerInterface $manager): Response
    {
        if($album == null) {
            $album = new Album();
            $mode = "ajouté";
        } else {
            $mode = "modifié";
        }

        $form = $this->createForm(AlbumType::class, $album);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $selectedStyles = $album->getStyles();
            $manager->persist($album);
            $manager->flush();

            $this->addFlash("success", "L'album a bien été $mode!");

            return $this->redirectToRoute('admin_albums');
        }

        return $this->render('admin/album/formAjoutModifAlbum.html.twig', [
            'formAlbum' => $form->createView()
        ]);
    }

    #[Route('/admin/album/supr/{id}', name: 'admin_album_supr', methods:['GET'])]
    public function suprAlbum(Album $album, EntityManagerInterface $manager): Response
    {
        $nbMorceaux = $morceau->getMorceaux()->count();

        if($nbMorceaux > 0) {
            $this->addFlash("danger", "Vous ne pouvez pas supprimer cet album car $nbMorceaux morceau(x) y sont associés!");
        } else {
            $manager->remove($album);
            $manager->flush();

            $this->addFlash("success", "L'album a bien été supprimé!");
        }

        return $this->redirectToRoute('admin_albums');
    }
}