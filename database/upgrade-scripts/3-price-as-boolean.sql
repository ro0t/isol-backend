update product p
  join product_nav_data_import i on p.id = i.product_id
  set p.price = 1 where i.UnitPrice != 0;

update product p
  join product_nav_data_import i on p.id = i.product_id
  set p.price = 0 where i.UnitPrice = 0;

ALTER TABLE product MODIFY price tinyint(1);