<?php

// +-----------+---------+------+-----+---------+----------------+
// | Field     | Type    | Null | Key | Default | Extra          |
// +-----------+---------+------+-----+---------+----------------+
// | id        | int(11) | NO   | PRI | NULL    | auto_increment |
// | orderId   | int(11) | NO   |     | NULL    |                |
// | productId | int(11) | NO   |     | NULL    |                |
// | quantity  | int(11) | NO   |     | NULL    |                |
// +-----------+---------+------+-----+---------+----------------+

class OrderDetail extends BaseEntity {
    private $orderId;
    private $productId;
    private $quantity;

    private $product;

    // Getter
    public function getOrderId() : int {
        return $this->orderId;
    }

    public function getProductId() : int {
        return $this->productId;
    }

    public function getQuantity() : int {
        return $this->quantity;
    }

    public function getProduct() : ?Product {
        return $this->product;
    }

    // Setter
    public function setOrderId(int $value) {
        $this->orderId = $value;
    }

    public function setProductId(int $value) {
        $this->productId = $value;
    }

    public function setQuantity(int $value) {
        $this->quantity = $value;
    }

    public function setProduct(?Product $product) {
        $this->product = $product;
    }

    public function serialize() : stdClass {
        $obj = new stdClass;

        $obj->id = $this->id;
        $obj->orderId = $this->orderId;
        $obj->productId = $this->productId;
        $obj->quantity = $this->quantity;

        if (isset($this->product)) {
            $obj->product = $this->product->serialize();
        }

        return $obj;
    }

    public static function deserialize(stdClass $obj) : OrderDetail {
        $details = new OrderDetail();

        $details->setId($obj->id);
        $details->setOrderId($obj->orderId);
        $details->setProductId($obj->productId);
        $details->setQuantity($obj->quantity);

        if (isset($obj->product)) {
            $prod = Product::deserialize($obj->product);
            $details->setProduct($prod);
        }

        return $details;
    }
}

?>