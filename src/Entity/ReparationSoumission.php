<?php

namespace App\Entity;

use App\Repository\ReparationSoumissionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ReparationSoumissionRepository::class)]
class ReparationSoumission
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $tel = null;

    #[ORM\Column(nullable: true)]
    private ?bool $promo_email = null;

    #[ORM\Column(nullable: true)]
    private ?bool $pub_email = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $composants = null;

    #[ORM\Column(nullable: true)]
    private ?float $totalPrice = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function isPromoEmail(): ?bool
    {
        return $this->promo_email;
    }

    public function setPromoEmail(?bool $promo_email): self
    {
        $this->promo_email = $promo_email;

        return $this;
    }

    public function isPubEmail(): ?bool
    {
        return $this->pub_email;
    }

    public function setPubEmail(?bool $pub_email): self
    {
        $this->pub_email = $pub_email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getComposants(): ?string
    {
        return $this->composants;
    }

    public function setComposants(string $composants): self
    {
        $this->composants = $composants;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(?float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
