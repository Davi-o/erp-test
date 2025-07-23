<?php
require_once "vendor/autoload.php";

session_start();

include 'view/partials/header.php';
include 'view/partials/cart-handler.php';
if(isset($_SESSION['checkout']) && $_SESSION['checkout'] === true){
    include 'view/partials/checkout.php';
} else {
    if($_SESSION['checkout'] === 'success'){
        echo "<script>alert('Pedido realizado com sucesso!')</script>";
        unset($_SESSION['checkout']);
    }
    include 'view/partials/product-list.php';
    include 'view/partials/shopping-cart.php';
}
include 'view/partials/footer.php';