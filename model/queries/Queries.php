<?php

namespace Enum;
use SplEnum;

class Queries
{
    const SELECT_ALL_PRODUCTS = "select * from product";
    const INSERT_INTO_PRODUCTS = "insert into product values(null, :product_name, :product_price, :product_variations)";
}