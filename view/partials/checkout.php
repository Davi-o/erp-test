<?php

if (empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit;
}

$subtotal = 0;

foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}

if ($subtotal > 200) {
    $frete = 0;
} elseif ($subtotal >= 52 && $subtotal <= 166.59) {
    $frete = 15;
} else {
    $frete = 20;
}

$total = $subtotal + $frete;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resumo do Pedido</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Resumo do Pedido</h2>

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
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>R$ <?= number_format($item['price'] * $item['quantity'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Frete</td>
                <td>R$ <?= number_format($frete, 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td><strong>R$ <?= number_format($total, 2, ',', '.') ?></strong></td>
            </tr>
        </tfoot>
    </table>

    <form action="finalizar.php" method="post">
        <button type="submit" class="btn btn-success">Finalizar Pedido</button>
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </form>
</body>
</html>
