create database if not exists erp;

use erp;

create table if not exists product(
    product_id integer primary key auto_increment not null,
    product_name varchar(60) not null,
    product_price float not null,
    product_variations  varchar(60)
);

create table if not exists product_stock(
    stock_id integer primary key auto_increment not null,
    p_id integer not null,
    stock_quantity integer,
    constraint fk_product_stock foreign key (p_id) references product(product_id)
);


create table if not exists purchase(
    purchase_id integer primary key auto_increment not null,
    purchase_total float,
    purchase_shipping_fee float
);

create table if not exists purchase_product(
    purchase_product_id integer primary key auto_increment not null,
    purchase_id int not null,
    product_id int not null,
    constraint fk_purchase foreign key (purchase_id) references purchase(purchase_id),
    constraint fk_product foreign key (product_id) references product(product_id)
);

create table if not exists discount(
    discount_id integer primary key auto_increment not null,
    discount_name varchar(60) not null,
    discount_value float not null,
    discount_minimum float not null, 
    discount_expiracy_date date not null
);

insert into erp.product values(null, "p1", 50.0, null);
insert into erp.product values(null, "p2", 60.0, null);
insert into erp.product values(null, "p3", 80.0, null);
insert into erp.product values(null, "p4", 100.0, null);

insert into erp.product_stock values(null, 1, 10);
insert into erp.product_stock values(null, 2, 10);
insert into erp.product_stock values(null, 3, 10);
insert into erp.product_stock values(null, 4, 10);

insert into discount values(null,"R$200+ frete gratis",100,52.00,'2025-12-20');
