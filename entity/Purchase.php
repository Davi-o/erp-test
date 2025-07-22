<?php
namespace Entity;

class Purchase
{
    private int $id;
    private array $products;
    private float $total;
    private float $shippingFee;

    public function __construct(
        int $id,
        array $products,
        int $total,
        int $shippingFee
    )
    {
        $this->id = $id;
        $this->products = $products;
        $this->total = $total;
        $this->shippingFee = $shippingFee;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function setProducts(?array $products)
    {
        $this->products = $products;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getShippingFee(): float
    {
        return $this->shippingFee;
    }
    
}