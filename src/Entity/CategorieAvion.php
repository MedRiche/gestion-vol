<?php

namespace App\Entity;

use App\Repository\CategorieAvionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieAvionRepository::class)]
class CategorieAvion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomCat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $compagnie = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Avion>
     */
    #[ORM\OneToMany(targetEntity: Avion::class, mappedBy: 'categorie')]
    private Collection $avions;

    public function __construct()
    {
        $this->avions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCat(): ?string
    {
        return $this->nomCat;
    }

    public function setNomCat(string $nomCat): static
    {
        $this->nomCat = $nomCat;

        return $this;
    }

    public function getCompagnie(): ?string
    {
        return $this->compagnie;
    }

    public function setCompagnie(?string $compagnie): static
    {
        $this->compagnie = $compagnie;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Avion>
     */
    public function getAvions(): Collection
    {
        return $this->avions;
    }

    public function addAvion(Avion $avion): static
    {
        if (!$this->avions->contains($avion)) {
            $this->avions->add($avion);
            $avion->setCategorie($this);
        }

        return $this;
    }

    public function removeAvion(Avion $avion): static
    {
        if ($this->avions->removeElement($avion)) {
            // set the owning side to null (unless already changed)
            if ($avion->getCategorie() === $this) {
                $avion->setCategorie(null);
            }
        }

        return $this;
    }
}
