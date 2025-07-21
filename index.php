<?php
require_once "vendor/autoload.php";

session_start();

include 'view/partials/header.php';
include 'view/partials/cart-handler.php';
if($_SESSION['checkout'] === true){
    include 'view/partials/checkout.php';
} else {
    include 'view/partials/product-list.php';
    include 'view/partials/shopping-cart.php';
}
include 'view/partials/footer.php';