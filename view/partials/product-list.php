<form action="view/index.php" method="post" id="new-product">
    <input type="hidden" name="action" value="create">
</form>

<form action="../index.php" method="post" id="new-purchase">
    <input type="hidden" name="action" value="start-purchase">
</form>

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
            <button type="submit" form="new-purchase" class="btn bg-success text-white">
                Comprar <i class="fa fa-plus"></i>
            </button>
        </th>
    </tr>
    <?php 
        include 'product-table.php';
    ?>
</table>