<?php

namespace Entity;

class Product
{
    private ?int $id = 0;
    private string $name;
    private float $price;
    private string $variations;

    public function __construct(
        ?int $id,
        string $name,
        float $price,
        ?string $variations
    )
    {
        !$id ?: $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        !$variations ?: $this->variations = $variations;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getVariations(): string
    {
        return $this->variations;
    }
    
}