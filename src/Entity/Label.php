<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LabelRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: LabelRepository::class)]
#[UniqueEntity(fields : ["nom"], message : "Le nom du label est déjà utiliser dans la base de donnée!")]
class Label
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le nom est obligatoire!")]
    #[Assert\Length(
        min : 1,
        max : 50,
        minMessage : "Le nom doit comporter au minimum {{ limit }}!",
        maxMessage : "Le nom doit comporter au maximum {{ limit }}!",
    )]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message:"La description est obligatoire!")]
    #[Assert\Length(
        min : 10,
        max : 255,
        minMessage : "La description doit comporter au minimum {{ limit }}!",
        maxMessage : "La description doit comporter au maximum {{ limit }}!",
    )]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"La date est obligatoire!")]
    #[Assert\Range(
        min: 1900,
        max: 2500,
        notInRangeMessage: "La label doit dater entre {{ min }} et {{ max }}.",
    )]
    private ?int $annee = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le type est obligatoire!")]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le logo est obligatoire!")]
    private ?string $logo = null;

    #[ORM\OneToMany(mappedBy: 'label', targetEntity: Album::class)]
    #[Assert\NotBlank(message:"Les Albums associées sont obligatoire!")]
    private Collection $albums;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): static
    {
        $this->logo = $logo;

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
            $album->setLabel($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): static
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getLabel() === $this) {
                $album->setLabel(null);
            }
        }

        return $this;
    }
}
