
<?php

use Controller\ProductController;   

$productController = new ProductController();
$products = $productController->getAllProducts();

if(count($products) > 0):
    foreach ($products as $product):  ?>
        <form action="view/index.php" method="post" id="editProduct-<?= $product->getId() ?>">
            <input type="hidden" name="action" value="load_edit_form">
        </form>
        <form action="view/index.php" method="post" id="deleteProduct-<?= $product->getId() ?>">
            <input type="hidden" name="action" value="delete">
        </form>

        <tr>
            <th scope="row"><?= $product->getId() ?></th>
            <input type="hidden" name="productId" value="<?= $product->getId() ?>" form="editProduct-<?= $product->getId() ?>">
            <input type="hidden" name="productId" value="<?= $product->getId() ?>" form="deleteProduct-<?= $product->getId() ?>">

            <td><?= $product->getName() ?></td>
            <td><?= $product->getPrice() ?></td>
            <td><?= $product->getVariations() ?></td>
            <td><?= $product->getQuantity() ?></td>
            <td>
                <button type="submit" form="editProduct-<?= $product->getId() ?>" class="btn btn-info">Editar</button>
                <button type="submit" form="deleteProduct-<?= $product->getId() ?>" class="btn btn-danger">Apagar</button>
                <?php if (!empty($_SESSION['purchase_mode'])): ?>
                    <form action="index.php" method="post" id="addToCart-<?= $product->getId() ?>">
                        <input type="hidden" name="action" value="add-to-cart">
                        <input type="hidden" name="productId" value="<?= $product->getId() ?>">
                    </form>
                    <button type="submit" form="addToCart-<?= $product->getId() ?>" class="btn btn-sm btn-primary mt-1">
                        + Carrinho
                    </button>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>