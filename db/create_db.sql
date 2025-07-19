create table if not exists product(
    product_id integer primary key autoincrement not null,
    product_name varchar(60) not null,
    product_price float not null,
    product_variations  integer
);

create table if not exists product_stock(
    stock_id integer primary key autoincrement not null,
    p_id integer not null,
    stock_quantity integer,
    constraint fk_product_stock foreign key (p_id) references product(product_id)
);

create table if not exists purchase(
    purchase_id integer primary key autoincrement not null,
    p_id integer not null,
    purchase_total float,
    purchase_shipping_fee float,
    constraint fk_product_purchase foreign key (p_id) references product(product_id)
);

create table if not exists discount(
    discount_id integer primary key autoincrement not null,
    discount_name varchar(60) not null,
    discount_value float not null,
    discount_minimum float not null, 
    discount_expiracy_date date not null
);


