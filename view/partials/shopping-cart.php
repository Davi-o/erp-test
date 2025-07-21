<?php if (!empty($_SESSION['cart'])): ?>
    <h3 class="mt-5">Carrinho</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Qtd</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $subtotal = 0;
                foreach ($_SESSION['cart'] as $productId => $product) {
                    $itemTotal = $product['product_price'] * $product['quantity'];
                    $subtotal += $itemTotal;
                    echo "<tr>
                        <td>{$product['product_name']}</td>
                        <td>{$product['quantity']}
                            <form action='index.php' method='post' class='d-inline'>
                                <input type='hidden' name='action' value='decrease_quantity'>
                                <input type='hidden' name='productId' value='{$productId}'>
                                <button class='btn btn-sm btn-secondary'> Remover </button>
                            </form>
                        </td>
                        <td>R$ " . number_format($itemTotal, 2, ',', '.') . "</td>
                    </tr>";
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

    <form action="index.php" method="post" class="d-inline">
        <input type="hidden" name="action" value="checkout">
        <button class="btn btn-success">Finalizar Compra</button>
    </form>
    <form action="index.php" method="post" class="d-inline">
        <input type="hidden" name="action" value="clear_cart">
        <button class="btn btn-warning">Limpar Carrinho</button>
    </form>
<?php endif; ?>