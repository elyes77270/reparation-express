<?php

namespace App\Entity;

use App\Repository\ComposantTelephoneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComposantTelephoneRepository::class)]
class ComposantTelephone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $prix = null;

    #[ORM\ManyToOne(inversedBy: 'composantTelephones', cascade: ['persist'])]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?Telephone $telephone = null;

    #[ORM\ManyToOne(inversedBy: 'composantTelephones', cascade: ['persist'])]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?Composant $composant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->getComposant(). ' : '. $this->getPrix(). '€';
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getTelephone(): ?Telephone
    {
        return $this->telephone;
    }

    public function setTelephone(?Telephone $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getComposant(): ?Composant
    {
        return $this->composant;
    }

    public function setComposant(?Composant $composant): self
    {
        $this->composant = $composant;

        return $this;
    }

}
