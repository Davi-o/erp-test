<?php
declare(strict_types=1);

require_once '../vendor/autoload.php';

use Entity\Product;
use Controller\ProductController;

$errors = [];
$productData = [
    'productId' => '',
    'productName' => '',
    'productPrice' => '',
    'productQuantity' => '',
    'productVariations' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productController = new ProductController();
    switch ($_POST['action']) {
        case 'load_edit_form':
            if (!empty($_POST['productId'])) {
                $product = $productController->getProduct((int)$_POST['productId']);
                if ($product) {
                    $productData = [
                        'productId' => $product->getId(),
                        'productName' => $product->getName(),
                        'productPrice' => $product->getPrice(),
                        'productQuantity' => $product->getQuantity(),
                        'productVariations' => $product->getVariations()
                    ];
                }
            }
            break;

        case 'create':
        case 'update':
            $productData['productId'] = filter_input(INPUT_POST, 'productId', FILTER_VALIDATE_INT) ?: '';
            $productData['productName'] = trim($_POST['productName'] ?? '');
            $productData['productPrice'] = filter_input(INPUT_POST, 'productPrice', FILTER_VALIDATE_FLOAT);
            $productData['productQuantity'] = filter_input(INPUT_POST, 'productQuantity', FILTER_VALIDATE_INT);
            $productData['productVariations'] = trim($_POST['productVariations'] ?? '');

            if ($productData['productName'] === '') {
                $errors['productName'] = 'Insira o nome do produto.';
            }
            if ($productData['productPrice'] === false || $productData['productPrice'] === null) {
                $errors['productPrice'] = 'Insira um valor válido para o produto.';
            }
            if ($productData['productQuantity'] === false || $productData['productQuantity'] < 0) {
                $errors['productQuantity'] = 'Quantidade não pode ser negativa.';
            }

            if (empty($errors)) {
                if ($_POST['action'] === 'update' && $productData['productId']) {
                    $success = $productController->updateProduct(new Product(
                        $productData['productId'],
                        $productData['productName'],
                        $productData['productPrice'],
                        $productData['productVariations'],
                        $productData['productQuantity']
                    ));
                } else {
                    $success = $productController->insertProduct(new Product(
                        null,
                        $productData['productName'],
                        $productData['productPrice'],
                        $productData['productVariations'],
                        $productData['productQuantity']
                    ));
                }

                if ($success) {
                    header('Location: ../index.php');
                    exit;
                }
            }
            break;

        case 'delete':
            if (!empty($_POST['productId']) && filter_var($_POST['productId'], FILTER_VALIDATE_INT)) {
                $productController->deleteProduct((int)$_POST['productId']);
                header('Location: ../index.php');
                exit;
            }
            break;
    }
}

$pageTitle = $productData['productId'] ? 'Editar Produto' : 'Criar Produto';

include 'partials/header.php';
include 'partials/cart-handler.php';
include 'partials/product-form.php';
include 'partials/shopping-cart.php';
include 'partials/footer.php';