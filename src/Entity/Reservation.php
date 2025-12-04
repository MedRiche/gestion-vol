<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $Reference = null;

    #[ORM\Column]
    private ?\DateTime $DateRes = null;

    #[ORM\Column(length: 50)]
    private ?string $Satut = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Client $client = null;

    #[ORM\OneToOne(mappedBy: 'reservation', cascade: ['persist', 'remove'])]
    private ?Paiement $paiement = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Vol $vol = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->Reference;
    }

    public function setReference(string $Reference): static
    {
        $this->Reference = $Reference;

        return $this;
    }

    public function getDateRes(): ?\DateTime
    {
        return $this->DateRes;
    }

    public function setDateRes(\DateTime $DateRes): static
    {
        $this->DateRes = $DateRes;

        return $this;
    }

    public function getSatut(): ?string
    {
        return $this->Satut;
    }

    public function setSatut(string $Satut): static
    {
        $this->Satut = $Satut;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getPaiement(): ?Paiement
    {
        return $this->paiement;
    }

    public function setPaiement(?Paiement $paiement): static
    {
        // unset the owning side of the relation if necessary
        if ($paiement === null && $this->paiement !== null) {
            $this->paiement->setReservation(null);
        }

        // set the owning side of the relation if necessary
        if ($paiement !== null && $paiement->getReservation() !== $this) {
            $paiement->setReservation($this);
        }

        $this->paiement = $paiement;

        return $this;
    }

    public function getVol(): ?Vol
    {
        return $this->vol;
    }

    public function setVol(?Vol $vol): static
    {
        $this->vol = $vol;

        return $this;
    }
}
