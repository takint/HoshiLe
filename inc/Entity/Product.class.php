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

    // Getter
    public function getName() : string {
        return $this->name;
    }

    public function getBrand() : string{
        return $this->brand;
    }

    public function getPrice() : float{
        return $this->price;
    }

    // Setter
    public function setName(string $value) {
        $this->name = $value;
    }

    public function setBrand(string $value) {
        $this->brand = $value;
    }

    public function setPrice(float $value) {
        $this->price = $value;
    }

    public function serialize() : stdClass {
        $obj = new stdClass;
        
        $obj->id = $this->id;
        $obj->name = $this->name;
        $obj->brand = $this->brand;
        $obj->price = $this->price;

        return $obj;
    }
}

?>