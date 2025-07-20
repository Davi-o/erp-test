<?php

namespace Enum;

class Queries
{
    const SELECT_ALL_PRODUCTS = "
        select 
            p.product_id as productId,
            p.product_name as productName,
            p.product_price as productPrice,
            p.product_variations as productVariations,
            ps.stock_quantity as productQuantity
        from 
            product as p
        inner join 
            product_stock as ps 
        on 
            p.product_id = ps.p_id
    ";

    const SELECT_PRODUCT_BY_ID = self::SELECT_ALL_PRODUCTS." where p.product_id = :product_id";

    const INSERT_INTO_PRODUCT = "insert into product values(null, :product_name, :product_price, :product_variations)";
    const INSERT_INTO_PRODUCT_STOCK = "insert into product_stock values(null, :product_id, :product_quantity)";

    const UPDATE_PRODUCT = "
        update 
            product 
        set 
            product_name = :product_name,
            product_price = :product_price,
            product_variations = :product_variations
        where 
            product_id = :product_id
    ";

    const UPDATE_PRODUCT_STOCK = "
        update 
            product_stock 
        set 
            stock_quantity = :product_quantity
        where 
            p_id = :product_id     
    ";

    const DELETE_PRODUCT = "
        delete from 
            product 
        where 
            product_id = :product_id;
    ";

    const DELETE_PRODUCT_STOCK = "
        delete from 
            product_stock 
        where 
            p_id = :product_id;
    ";

}