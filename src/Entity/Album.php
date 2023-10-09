<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
#[UniqueEntity(fields : ["nom", "artiste"], message : "Le nom de l'album et l'artiste sont déjà tout les deux ensemble dans la base de donnée!")]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"IDENTITY")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[NotBlank(message:"Le nom est obligatoire!")]
    #[Assert\Length(
        min : 1,
        max : 50,
        minMessage : "Le nom doit comporter au minimum {{ limit }}!",
        maxMessage : "Le nom doit comporter au maximum {{ limit }}!",
    )]
    private ?string $nom = null;

    #[ORM\Column]
    #[Assert\Range(
        min: 1940,
        max: 2099,
        notInRangeMessage: "L'album doit dater entre {{ min }} et {{ max }}.",
    )]
    private ?int $date = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'albums')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message:"L'artiste' est obligatoire!")]
    private ?Artiste $artiste = null;

    #[ORM\OneToMany(mappedBy: 'album', targetEntity: Morceau::class)]
    private Collection $morceaux;

    #[ORM\ManyToMany(targetEntity: Style::class, mappedBy: 'albums')]
    #[Assert\Count(
        min : 1,
        minMessage : "Au moins un style doit être sélectionné!",
    )]
    private Collection $styles; 

    public function __construct()
    {
        $this->morceaux = new ArrayCollection();
        $this->styles = new ArrayCollection();
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

    public function getDate(): ?int
    {
        return $this->date;
    }

    public function setDate(int $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getArtiste(): ?artiste
    {
        return $this->artiste;
    }

    public function setArtiste(?artiste $artiste): static
    {
        $this->artiste = $artiste;

        return $this;
    }

    /**
     * @return Collection<int, Morceau>
     */
    public function getmorceaux(): Collection
    {
        return $this->morceaux;
    }

    public function addmorceaux(Morceau $morceaux): static
    {
        if (!$this->morceaux->contains($morceaux)) {
            $this->morceaux->add($morceaux);
            $morceaux->setAlbum($this);
        }

        return $this;
    }

    public function removemorceaux(Morceau $morceaux): static
    {
        if ($this->morceaux->removeElement($morceaux)) {
            // set the owning side to null (unless already changed)
            if ($morceaux->getAlbum() === $this) {
                $morceaux->setAlbum(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Style>
     */
    public function getStyles(): Collection
    {
        return $this->styles;
    }

    public function addStyle(Style $style): static
    {
        if (!$this->styles->contains($style)) {
            $this->styles->add($style);
            $style->addAlbum($this);
        }

        return $this;
    }

    public function removeStyle(Style $style): static
    {
        if ($this->styles->removeElement($style)) {
            $style->removeAlbum($this);
        }

        return $this;
    }
}
