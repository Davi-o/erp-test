<?php
namespace Controller;

use Model\ProductModel;

class ProductController
{
    private ProductModel $productModel;
    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function getAllProducts(): array
    {
        return $this->productModel->getAllProducts();
    }
}