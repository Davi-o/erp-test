<?php
require_once "vendor/autoload.php";

use Controller\ProductController;

$productController = new ProductController();

$productsTable = "";
foreach ($productController->getAllProducts() as $product) {
    echo "
        <form
            action='view/form.php' 
            method='post' 
            id='editProduct-{$product->getId()}'
        ></form>
    ";

    echo "
        <form
            action='view/delete.php' 
            method='post' 
            id='deleteProduct-{$product->getId()}'
        ></form>
    ";

    $hidden = "
        <input 
            name='id' 
            type='hidden' 
            form='editProduct-{$product->getId()}'
            value='{$product->getId()}' 
        />
        <input 
            name='id' 
            type='hidden' 
            form='deleteProduct-{$product->getId()}'
            value='{$product->getId()}' 
        />
    ";

    $productsTable .= "
        <tr>
            <th scope='row'>{$product->getId()}</th>
            {$hidden}
            <td>{$product->getName()}</td>
            <td>{$product->getPrice()}</td>
            <td>{$product->getVariations()}</td>
            <td>0000035</td>
            <td>
                <button type='submit' form='editProduct-{$product->getId()}' class='btn btn-info'>Editar</button>
                <button type='submit' form='deleteProduct-{$product->getId()}' class='btn btn-danger'>Apagar</button>
            </td>
        </tr>
    ";
}

echo
"<html>
    <header>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js' integrity='sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4' crossorigin='anonymous'></script>
        <script src='view/js/main.js'></script>
    </header>
    <body>
        <div class='container'>
            <form
                action='view/form.php'
                method='post'
                id='new-product'
            ></form>
            <table class='table table-striped table-bordered'>
              <tr>
                <th scope='col'>Id</th>
                <th scope='col'>Nome</th>
                <th scope='col'>Preco</th>
                <th scope='col'>Variacoes</th>
                <th scope='col'>Qtd.Estoque</th>
                <th scope='col'>                    
                    <button
                        type='submit'
                        form='new-product'
                        class='btn bg-info text-white'  
                    > Adicionar um novo produto <i class='fa fa-plus'></i>
                    </button>
                </th>
              </tr>
              {$productsTable}
            </table>
        </div>
    </body>
</html>";