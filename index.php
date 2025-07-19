<?php
require_once "vendor/autoload.php";

use Controller\ProductController;

$productController = new ProductController();
var_dump($productController->getAllProducts());