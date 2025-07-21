<?php

use Controller\ProductController;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $productController = new ProductController();
    switch ($_POST['action']) {
        case 'start-purchase':
            $_SESSION['purchase_mode'] = true;
            break;

        case 'add-to-cart':
            $productId = (int) $_POST['productId'];
            $product = $productController->getProduct($productId);

            if ($product && $product->getQuantity() > 0) {
                $_SESSION['cart'] ??= [];

                $_SESSION['cart'][$productId] ??= [
                    'product_name' => (string) $product->getName(),
                    'product_price' => (float) $product->getPrice(),
                    'quantity' => 0
                ];

                if ($_SESSION['cart'][$productId]['quantity'] < $product->getQuantity()) {
                    $_SESSION['cart'][$productId]['quantity'] += 1;
                }
            }
            break;

        case 'decrease_quantity':
            $productId = $_POST['productId'];
            $cartQuantity = $_SESSION['cart'][$productId]['quantity'];
            $productQuantity = &$_SESSION['cart'][$productId]['quantity'];
            
            $productQuantity = $cartQuantity - 1;
            
            if($productQuantity <= 0) {
                unset($_SESSION['cart'][$productId]);
                
                if(count($_SESSION['cart'])<=0){
                    unset($_SESSION['cart']);
                    $_SESSION['purchase_mode'] = false;
                }
            }
            break;

        case 'clear_cart':
            unset($_SESSION['cart']);
            $_SESSION['purchase_mode'] = false;
            break;

        case 'checkout':
            $_SESSION['checkout'] = true;
            break;
    }
}