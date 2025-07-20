<form action="view/form.php" method="post" id="new-product"></form>

<table class="table table-striped table-bordered">
    <tr>
        <th scope="col">Id</th>
        <th scope="col">Nome</th>
        <th scope="col">Preço</th>
        <th scope="col">Variações</th>
        <th scope="col">Qtd. Estoque</th>
        <th scope="col">
            <button type="submit" form="new-product" class="btn bg-info text-white">
                Adicionar um novo produto <i class="fa fa-plus"></i>
            </button>
        </th>
    </tr>

    <?php foreach ($productController->getAllProducts() as $product): ?>
        <form action="view/form.php" method="post" id="editProduct-<?= $product->getId() ?>">
            <input type="hidden" name="action" value="load_edit_form">
        </form>
        <form action="view/form.php" method="post" id="deleteProduct-<?= $product->getId() ?>">
            <input type="hidden" name="action" value="delete">
        </form>

        <tr>
            <th scope="row"><?= $product->getId() ?></th>
            <input type="hidden" name="productId" value="<?= $product->getId() ?>" form="editProduct-<?= $product->getId() ?>">
            <input type="hidden" name="productId" value="<?= $product->getId() ?>" form="deleteProduct-<?= $product->getId() ?>">

            <td><?= htmlspecialchars($product->getName()) ?></td>
            <td><?= htmlspecialchars($product->getPrice()) ?></td>
            <td><?= htmlspecialchars($product->getVariations()) ?></td>
            <td><?= htmlspecialchars($product->getQuantity()) ?></td>
            <td>
                <button type="submit" form="editProduct-<?= $product->getId() ?>" class="btn btn-info">Editar</button>
                <button type="submit" form="deleteProduct-<?= $product->getId() ?>" class="btn btn-danger">Apagar</button>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
