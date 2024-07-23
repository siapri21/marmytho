<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
#[UniqueEntity('slug')]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $slug = null;

    #[ORM\Column(length: 50 , nullable: true)]
    #[Assert\Range(min: 1 , max: 1440)]
    private ?int $temps = null;

    #[ORM\Column(length: 255)]
    #[Assert\LessThan(50)]
    private ?int $nmbre_person = null;

    #[ORM\Column(length: 255)]
    #[Assert\Range(min: 1 , max: 5)]
    private ?int $difficulte = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\Range(min: 1 , max: 1000)]
    private ?float $price = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updateAt = null;

    
    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updateAt= new \DateTimeImmutable();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTemps(): ?int
    {
        return $this->temps;
    }

    public function setTemps(?int $temps): static
    {
        $this->temps = $temps;

        return $this;
    }

    public function getNmbrePerson(): ?int
    {
        return $this->nmbre_person;
    }

    public function setNmbrePerson(int $nmbre_person): static
    {
        $this->nmbre_person = $nmbre_person;

        return $this;
    }

    public function getDifficulte(): ?int
    {
        return $this->difficulte;
    }

    public function setDifficulte(int $difficulte): static
    {
        $this->difficulte = $difficulte;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
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

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    
}
