<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\StyleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: StyleRepository::class)]
#[UniqueEntity(fields : ["nom"], message : "Le nom du style est déjà utiliser dans la base de donnée!")]
#[UniqueEntity(fields : ["couleur"], message : "La couleur du style est déjà utiliser dans la base de donnée!")]
class Style
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"IDENTITY")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le nom est obligatoire!")]
    #[Assert\Length(
        min : 3,
        max : 50,
        minMessage : "Le nom doit comporter au minimum {{ limit }}!",
        maxMessage : "Le nom doit comporter au maximum {{ limit }}!",
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"La couleur est obligatoire")]
    private ?string $couleur = null;

    #[ORM\ManyToMany(targetEntity: Album::class, inversedBy: 'styles')]
    private Collection $albums;

    public function __toString()
{
    return $this->nom;
}

    public function __construct()
    {
        $this->albums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): static
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * @return Collection<int, Album>
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): static
    {
        if (!$this->albums->contains($album)) {
            $this->albums->add($album);
        }

        return $this;
    }

    public function removeAlbum(Album $album): static
    {
        $this->albums->removeElement($album);

        return $this;
    }
}
