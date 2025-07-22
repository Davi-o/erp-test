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

    const SELECT_ALL_PURCHASES = "
        select 
            purchase_id as purchaseId,
            purchase_total as purchaseTotal,
            purchase_shipping_fee as purchaseShippingFee
        from
            purchase
    ";

    const SELECT_ALL_PURCHASE_PRODUCT = "
        select 
            pp.purchase_id as purchaseId,
            pr.product_id as productId,
            pr.product_name as productName,
            pr.product_price as productPrice,
            pr.product_variations as productVariations,
            pp.product_quantity as productQuantity
        from
            purchase_product pp
        join
            product pr on pr.product_id = pp.product_id
    ";

    const SELECT_PURCHASES_WITH_PRODUCTS = "
        select 
            p.purchase_id as purchaseId,
            p.purchase_total as purchaseTotal,
            p.purchase_shipping_fee as purchaseShippingFee,
            
            pr.product_id as productId,
            pr.product_name as productName,
            pr.product_price as productPrice,
            pr.product_variations as productVariations,
            pp.product_quantity AS productQuantity

        from purchase p
        join purchase_product pp on pp.purchase_id = p.purchase_id
        join product pr on pr.product_id = pp.product_id
        order by p.purchase_id
    ";

    const INSERT_INTO_PURCHASE = "insert into purchase values(null, :purchase_total , :purchase_shipping_fee)";
    const INSERT_INTO_PURCHASE_PRODUCT = "insert into purchase_product values (null, :purchase_id, :product_id, :quantity)";

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