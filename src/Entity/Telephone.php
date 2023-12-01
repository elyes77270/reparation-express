<?php

namespace App\Entity;

use App\Repository\TelephoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TelephoneRepository::class)]
class Telephone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'telephones')]
    private ?Marque $marque = null;

    #[ORM\OneToMany(mappedBy: 'telephone', targetEntity: ComposantTelephone::class, cascade: ['persist'])]
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

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
            $composantTelephone->setTelephone($this);
        }

        return $this;
    }

    public function removeComposantTelephone(ComposantTelephone $composantTelephone): self
    {
        if ($this->composantTelephones->removeElement($composantTelephone)) {
            // set the owning side to null (unless already changed)
            if ($composantTelephone->getTelephone() === $this) {
                $composantTelephone->setTelephone(null);
            }
        }

        return $this;
    }
}
