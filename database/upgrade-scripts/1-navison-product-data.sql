create table product_nav_data_import (
  product_id              int                                     not null,
  UnitPrice               double                                  null,
  UnitPricePerSalesUOM    double                                  null,
  UnitPricePerSalesUOMVAT double                                  null,
  UnitCost                double                                  null,
  updated_at              timestamp default '2019-01-01 01:00:00' not null,
  created_at              timestamp default CURRENT_TIMESTAMP     not null,
  constraint product_nav_data_import_product_id_fk
  foreign key (product_id) references product (id)
    on delete cascade
);

ALTER TABLE product ADD last_nav_sync_date TIMESTAMP default '2019-01-01 00:00' NULL;