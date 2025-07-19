<?php

namespace Model;

use Database\Connection;
use Entity\product;
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
}