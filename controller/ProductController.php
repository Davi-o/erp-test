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

    public function getProduct(int $id): Product
    {
        return $this->productModel->getProduct($id);
    }

    public function insertProduct(Product $product): bool
    {
        return $this->productModel->insertProduct($product);
    }

    public function updateProduct(Product $product): bool
    {
        return $this->productModel->updateProduct($product);
    }

    public function deleteProduct(int $id): bool
    {
        return $this->productModel->deleteProduct($id);
    }
}