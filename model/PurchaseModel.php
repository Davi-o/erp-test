<?php

namespace Model;

use Database\Connection;
use Entity\Product;
use Entity\Purchase;
use Enum\Queries;

class PurchaseModel
{
    private Connection $connection;
    private ProductModel $productModel;
    
    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    public function getAllPurchases(): ?array
    {
        $statement = $this->connection->prepare(Queries::SELECT_ALL_PURCHASES);
        $statement->execute();
        $response = [];
        while($fetch = $statement->fetch()) {
            $response[] = new Purchase(
                $fetch['purchaseId'],
                [],
                $fetch['purchaseTotal'],
                $fetch['purchaseShippingFee']
            );
        }

        return $response ?? null;
    }

    public function getAllPurchasesWithProducts(): array
    {
        $statement = $this->connection->prepare(Queries::SELECT_PURCHASES_WITH_PRODUCTS);
        $statement->execute();

        $purchases = [];

        while ($purchase = $statement->fetch()) {
            $purchaseId = $purchase['purchaseId'];

            if (!isset($purchases[$purchaseId])) {
                $purchases[$purchaseId] = new Purchase(
                    $purchaseId,
                    [],
                    $purchase['purchaseTotal'],
                    $purchase['purchaseShippingFee']
                );
            }

            $product = new Product(
                $purchase['productId'],
                $purchase['productName'],
                $purchase['productPrice'],
                $purchase['productVariations'],
                $purchase['productQuantity']
            );

            $products = $purchases[$purchaseId]->getProducts();
            $products[] = $product;
            $purchases[$purchaseId]->setProducts($products);
        }

        return $purchases;
    }

    public function createPurchase(array $cart, float $total, float $shipping): int
    {
        $productModel = new ProductModel();
        try {
            $this->connection->beginTransaction();

            $stmt = $this->connection->prepare(Queries::INSERT_INTO_PURCHASE);
            $stmt->execute([
                ':purchase_total' => $total,
                ':purchase_shipping_fee' => $shipping
            ]);
            $purchaseId = (int) $this->connection->lastInsertId();

            $purchaseProduct = $this->connection->prepare(Queries::INSERT_INTO_PURCHASE_PRODUCT);
            
            $productStock = $this->connection->prepare(Queries::UPDATE_PRODUCT_STOCK);

            foreach ($cart as $productId => $item) {
                $purchaseProduct->bindValue(":purchase_id", $purchaseId);
                $purchaseProduct->bindValue(":product_id", $productId);
                $purchaseProduct->bindValue(":quantity", $item['quantity']);
                
                $productToUpdate = $productModel->getProduct($productId);

                $productStock->bindValue(":product_id", $productId);
                $productStock->bindValue(":product_quantity", $productToUpdate->getQuantity() - $item['quantity']);
                if(!($purchaseProduct->execute() && $productStock->execute())){
                    throw new \Exception("Failed to create purchase.");
                }
                
            }

            $this->connection->commit();
            return $purchaseId;

        } catch (\Exception $e) {
            $this->connection->rollBack();
            error_log($e->getMessage() . PHP_EOL, 3, "/var/tmp/erp-db-err.log");
            throw new \Exception("Erro ao finalizar pedido: " . $e->getMessage());
        }
    }
}