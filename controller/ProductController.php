<?php
namespace Controller;

use Entity\Product;
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

    public function insertProduct(Product $product): bool
    {
        return $this->productModel->insertProduct($product);
    }
}