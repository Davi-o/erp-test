<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" class="p-4 rounded bg-light shadow-sm">

    <?php
    if (!empty($_POST['productId'])): ?>
        <input type="hidden" name="productId" value="<?= $productData['productId'] ?>">
        <input type="hidden" name="action" value="update">
    <?php endif; ?>
    <?php if (empty($_POST['productId'])): ?>
        <input type="hidden" name="action" value="create">
    <?php endif; ?>

    <div class="mb-3">
        <label for="productName" class="form-label">Nome</label>
        <input 
            type="text" 
            class="form-control <?= isset($errors['productName']) ? 'is-invalid' : '' ?>" 
            name="productName" 
            id="productName" 
            value="<?= $productData['productName'] ?>" 
            required
        >
        <?php if (isset($errors['productName'])): ?>
            <div class="invalid-feedback"><?= $errors['productName'] ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="productPrice" class="form-label">Preço</label>
        <input 
            type="text" 
            class="form-control <?= isset($errors['productPrice']) ? 'is-invalid' : '' ?>" 
            name="productPrice" 
            id="productPrice" 
            value="<?= $productData['productPrice'] ?>" 
            required
        >
        <?php if (isset($errors['productPrice'])): ?>
            <div class="invalid-feedback"><?= $errors['productPrice'] ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="productQuantity" class="form-label">Quantidade</label>
        <input 
            type="number" 
            class="form-control <?= isset($errors['productQuantity']) ? 'is-invalid' : '' ?>" 
            name="productQuantity" 
            id="productQuantity" 
            value="<?= $productData['productQuantity'] ?>"
        >
        <?php if (isset($errors['productQuantity'])): ?>
            <div class="invalid-feedback"><?= $errors['productQuantity'] ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="productVariations" class="form-label">Variações</label>
        <input 
            type="text" 
            class="form-control" 
            name="productVariations" 
            id="productVariations" 
            value="<?= $productData['productVariations'] ?>"
        >
    </div>

    <button type="submit" class="btn btn-primary">
        <?= $productData['productId'] ? 'Atualizar' : 'Criar' ?>
    </button>
</form>
