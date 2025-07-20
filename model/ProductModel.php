<?php

namespace Model;

use Database\Connection;
use Entity\Product;
use Enum\Queries;

class ProductModel
{
    private Connection $connection;
    
    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    public function getAllProducts(): ?array
    {
        $statement = $this->connection->prepare(Queries::SELECT_ALL_PRODUCTS);
        $statement->execute();
        $response = [];

        while($fetch = $statement->fetch()) {
            $response[] = new Product(
                $fetch['productId'],
                $fetch['productName'],
                $fetch['productPrice'],
                $fetch['productVariations'],
                $fetch['productQuantity']
            );
        }

        return $response ?? null;
    }

    public function getProduct(int $id): Product
    {
        $statement = $this->connection->prepare(Queries::SELECT_PRODUCT_BY_ID);
        
        $statement->bindValue(":product_id", $id);
        $statement->execute();
        
        $fetch = $statement->fetch();

        return new Product(
            $fetch['productId'],
            $fetch['productName'],
            $fetch['productPrice'],
            $fetch['productVariations'],
            $fetch['productQuantity']
        );

    }

    public function insertProduct(Product $product): bool
    {
        try {
            $this->connection->beginTransaction();

            $statement = $this->connection->prepare(Queries::INSERT_INTO_PRODUCT);
            $statement->bindValue(":product_name", $product->getName());
            $statement->bindValue(":product_price", $product->getPrice());
            $statement->bindValue(":product_variations", $product->getVariations());

            if (!$statement->execute()) {
                throw new \Exception("Failed to insert product.", 1);
            }
            
            if (!$this->insertProductStock($product->getQuantity(), $this->connection->lastInsertId())) {
                throw new \Exception("Failed to insert product stock.", 1);
            }

            return $this->connection->commit();

        } catch (\Throwable $e) {
            $this->connection->rollBack();
            error_log($e->getMessage() . PHP_EOL, 3, "/var/tmp/erp-db-err.log");
            return false;
        }
    }

    public function insertProductStock(int $quantity, int $id): bool
    {
        $statement = $this->connection->prepare(Queries::INSERT_INTO_PRODUCT_STOCK);
        $statement->bindValue(":product_id", $id);
        $statement->bindValue(":product_quantity", $quantity);

        return $statement->execute();
    }

    public function updateProduct(Product $product): bool
    {
        try {
            $this->connection->beginTransaction();

            $statement = $this->connection->prepare(Queries::UPDATE_PRODUCT);
            $statement->bindValue(":product_name", $product->getName());
            $statement->bindValue(":product_price", $product->getPrice());
            $statement->bindValue(":product_variations", $product->getVariations() ?? 0);
            $statement->bindValue(":product_id", $product->getId());
            
            if(!$statement->execute()){
                throw new \Exception("Failed to update product.", 1);
            }

            if(!$this->updateProductStock($product)){
                throw new \Exception("Failed to update the product stock.", 1);
            }

            return $this->connection->commit();

        } catch (\Throwable $e) {
            $this->connection->rollBack();
            error_log($e->getMessage() . PHP_EOL, 3, "/var/tmp/erp-db-err.log");
            return false;
        }
    }

    public function updateProductStock(Product $product): bool
    {
        $statement = $this->connection->prepare(Queries::UPDATE_PRODUCT_STOCK);
        $statement->bindValue(":product_id", $product->getId());
        $statement->bindValue(":product_quantity", $product->getQuantity());

        return $statement->execute();
    }

    public function deleteProduct(int $id): bool
    {
        try {

            $this->connection->beginTransaction();
    
            $statement = $this->connection->prepare(Queries::DELETE_PRODUCT);
            $statement->bindValue(":product_id", $id);
            
            if(!$this->deleteProductStock($id)){
                throw new \Exception("Failed to delete product stock.", 1);
            }
            if(!$statement->execute()){
                throw new \Exception("Failed to delete product.", 1);
            }
            
            
            return $this->connection->commit();

        } catch (\Throwable $e) {
            $this->connection->rollBack();
            error_log($e->getMessage() . PHP_EOL, 3, "/var/tmp/erp-db-err.log");
            return false;
        }
    }

    public function deleteProductStock(int $id): bool
    {
        $statement = $this->connection->prepare(Queries::DELETE_PRODUCT_STOCK);
        $statement->bindValue(":product_id", $id);

        return $statement->execute();
    }
}