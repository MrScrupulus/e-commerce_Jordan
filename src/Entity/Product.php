<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le nom du produit est obligatoire')]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le modèle du produit est obligatoire')]
    private ?string $model = null;

    #[ORM\Column]
    #[Assert\Positive(message: 'Le prix doit être positif')]
    private ?float $price = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero(message: 'La quantité doit être positive ou nulle')]
    private ?int $quantity = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'L\'image du produit est obligatoire')]
    private ?string $image = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le type du produit est obligatoire')]
    #[Assert\Choice(choices: ['vêtement', 'basket'], message: 'Le type doit être soit "vêtement" soit "basket"')]
    private ?string $type = null;

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

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function isAvailable(): bool
    {
        return $this->quantity > 0;
    }
}
