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
    /**
     * @todo fazer a busca do estoque e possivelmente das variacoes
     */
    public function getAllProducts(): ?array
    {
        $statement = $this->connection->prepare(Queries::SELECT_ALL_PRODUCTS);
        $statement->execute();
        $response = [];
        while($fetch = $statement->fetch()) {
            $product = new product(
                $fetch['product_id'],
                $fetch['product_name'],
                $fetch['product_price'],
                null
            );
            
            $response[]= $product;
        }

        return $response ?? null;
    }

    /**
     * @todo cadastrar estoque e possivelmente variacoes
     */
    public function insertProduct(Product $product): bool
    {
        $statement = $this->connection->prepare(Queries::INSERT_INTO_PRODUCTS);
        $statement->bindValue(":product_name",$product->getName());
        $statement->bindValue(":product_price", $product->getPrice());
        $statement->bindValue(":product_variations", $product->getVariations());

        return $statement->execute();
    }
}