<?php

// +----------+---------------+------+-----+---------+----------------+
// | Field    | Type          | Null | Key | Default | Extra          |
// +----------+---------------+------+-----+---------+----------------+
// | id       | int(11)       | NO   | PRI | NULL    | auto_increment |
// | name     | varchar(255)  | NO   |     | NULL    |                |
// | brand    | varchar(255)  | NO   |     | NULL    |                |
// | price    | decimal(10,2) | NO   |     | NULL    |                |
// | imageUrl | varchar(255)  | NO   |     | NULL    |                |
// +----------+---------------+------+-----+---------+----------------+

class Product extends BaseEntity {
    
    private $name;
    private $brand;
    private $price;
    private $imageUrl;

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

    public function getImageUrl() : string {
        return $this->imageUrl;
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

    public function setImageUrl(string $value) {
        $this->imageUrl = $value;
    }

    public function serialize() : stdClass {
        $obj = new stdClass;
        
        $obj->id = $this->id;
        $obj->name = $this->name;
        $obj->brand = $this->brand;
        $obj->price = $this->price;
        $obj->imageUrl = $this->imageUrl;

        return $obj;
    }

    public static function deserialize(stdClass $obj) : Product {
        $product = new Product();

        $product->setId($obj->id);
        $product->setName($obj->name);
        $product->setBrand($obj->brand);
        $product->setPrice($obj->price);
        $product->setImageUrl($obj->imageUrl);

        return $product;
    }
}

?>