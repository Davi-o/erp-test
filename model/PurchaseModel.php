<?php

namespace Model;

use Database\Connection;
use Entity\Purchase;
use Enum\Queries;

class PurchaseModel
{
    private Connection $connection;
    
    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    /**
     * @todo
     */
    public function getAllPurchases(): ?array
    {
        $statement = $this->connection->prepare(Queries::SELECT_ALL_PURCHASES);
        $statement->execute();
        $response = [];
        // while($fetch = $statement->fetch()) {
        //     $response[] = new Purchase(
        //         $fetch['']
        //     );
        // }
        return $response;
    }
}