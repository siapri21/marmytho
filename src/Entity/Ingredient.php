<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: IngredientRepository::class)]
// Permet de définir des méthodes qui seront automatiquement appelées à certains moments du cycle de vie de l'entité, comme avant ou après la persistance, la mise à jour, la suppression, etc.
#[HasLifecycleCallbacks]
// elle verifier pour voir s'il y'a pas de doublons tout en assurance l'unicite de  name
#[UniqueEntity('name')]

class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2, max:50)]
    private ?string $name = null;

    #[ORM\Column(nullable:true)]
    #[Assert\Positive()]
    #[Assert\LessThanOrEqual(200)]
    private ?float $price = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;


    #[ORM\PrePersist]
    public function setcreatevalue() 
    {
        $this->createAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }
}
