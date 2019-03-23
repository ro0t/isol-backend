-- update product_category set parent = 0 where id > 0;
update product_category set parent = 0 where parent is null;
alter table product_category modify parent int(11) not null default 0;

DELIMITER //
CREATE PROCEDURE getProductCategories
  (IN pcId INT(11))
  BEGIN
    select p.id, p.image, p.name, p.parent, p.active, p.slug, p.order, (select count(pc.id) from product_category as pc where pc.active = 1 and pc.parent = p.id) as childCount
    from product_category as p
    where p.active = 1 and p.parent = pcId
    order by p.order asc;
  END //
DELIMITER ;