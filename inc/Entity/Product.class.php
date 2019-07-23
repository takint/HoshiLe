<?php

// +-------+---------------+------+-----+---------+----------------+
// | Field | Type          | Null | Key | Default | Extra          |
// +-------+---------------+------+-----+---------+----------------+
// | id    | int(11)       | NO   | PRI | NULL    | auto_increment |
// | name  | varchar(255)  | NO   |     | NULL    |                |
// | brand | varchar(255)  | NO   |     | NULL    |                |
// | price | decimal(10,2) | NO   |     | NULL    |                |
// +-------+---------------+------+-----+---------+----------------+

class Product extends BaseEntity {
    private $name;
    private $brand;
    private $price;
}

?>