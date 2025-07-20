<?php
require_once "vendor/autoload.php";

use Controller\ProductController;

$productController = new ProductController();

include 'view/partials/header.php';
include 'view/partials/product-list.php';
include 'view/partials/footer.php';
