<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';

use Controller\PurchaseController;

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_order'] )) {
    try {
        $controller = new PurchaseController();
        $purchaseId = $controller->createPurchase($_SESSION['cart']);
        
        unset($_SESSION['cart']);
        $_SESSION['checkout'] = 'success';
        header('Location: ../../index.php');
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$subtotal = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $subtotal += $item['product_price'] * $item['quantity'];
    }

    $shippingFee = ($subtotal > 200) ? 0 : (($subtotal >= 52 && $subtotal <= 166.59) ? 15 : 20);
    $total = $subtotal + $shippingFee;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Resumo do Pedido</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php elseif (!empty($_SESSION['cart'])): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <tr>
                        <td><?= $item['product_name'] ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>R$ <?= number_format($item['product_price'] * $item['quantity'], 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr><td colspan="2">Frete</td><td>R$ <?= number_format($shippingFee, 2, ',', '.') ?></td></tr>
                <tr><td colspan="2"><strong>Total</strong></td><td><strong>R$ <?= number_format($total, 2, ',', '.') ?></strong></td></tr>
            </tfoot>
        </table>

        <form method="post">
            <input type="hidden" name="create_order" value="1">
            <button class="btn btn-success">Finalizar Pedido</button>
            <a href="index.php" class="btn btn-secondary">Voltar</a>
        </form>
    <?php else: ?>
        <div class="alert alert-info">Carrinho vazio.</div>
        <a href="index.php" class="btn btn-primary">Voltar</a>
    <?php endif; ?>
</body>
</html>