<?php

namespace App\Entity;

use App\Repository\ComposantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComposantRepository::class)]
class Composant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(nullable: true)]
    private ?float $prix = null;

    #[ORM\OneToMany(mappedBy: 'composant', targetEntity: ComposantTelephone::class, cascade: ['persist'])]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private Collection $composantTelephones;

    public function __construct()
    {
        $this->composantTelephones = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getNom();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
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

    /**
     * @return Collection<int, ComposantTelephone>
     */
    public function getComposantTelephones(): Collection
    {
        return $this->composantTelephones;
    }

    public function addComposantTelephone(ComposantTelephone $composantTelephone): self
    {
        if (!$this->composantTelephones->contains($composantTelephone)) {
            $this->composantTelephones->add($composantTelephone);
            $composantTelephone->setComposant($this);
        }

        return $this;
    }

    public function removeComposantTelephone(ComposantTelephone $composantTelephone): self
    {
        if ($this->composantTelephones->removeElement($composantTelephone)) {
            // set the owning side to null (unless already changed)
            if ($composantTelephone->getComposant() === $this) {
                $composantTelephone->setComposant(null);
            }
        }

        return $this;
    }
}
