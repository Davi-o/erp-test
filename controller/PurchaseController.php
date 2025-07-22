<?php

namespace Controller;
use Model\PurchaseModel;

class PurchaseController
{
    private PurchaseModel $purchaseModel;

    public function __construct()
    {
        $this->purchaseModel = new PurchaseModel();   
    }

    public function createPurchase(array $cart): int
    {
        if (empty($cart)) {
            throw new \Exception("Carrinho está vazio.");
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['product_price'] * $item['quantity'];
        }

        $shipping = ($subtotal > 200) ? 0 : (($subtotal >= 52 && $subtotal <= 166.59) ? 15 : 20);
        $total = $subtotal + $shipping;

        return $this->purchaseModel->createPurchase($cart, $total, $shipping);
    }
}