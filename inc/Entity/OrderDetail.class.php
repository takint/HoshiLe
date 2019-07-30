<?php

// +-----------+---------+------+-----+---------+----------------+
// | Field     | Type    | Null | Key | Default | Extra          |
// +-----------+---------+------+-----+---------+----------------+
// | id        | int(11) | NO   | PRI | NULL    | auto_increment |
// | orderId   | int(11) | NO   |     | NULL    |                |
// | productId | int(11) | NO   |     | NULL    |                |
// | quantity  | int(11) | NO   |     | NULL    |                |
// +-----------+---------+------+-----+---------+----------------+

class OrderDetail {
    private $orderId;
    private $productId;
    private $quantity;

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

    public function serialize() : stdClass {
        $obj = new stdClass;

        $obj->id = $this->id;
        $obj->orderId = $this->orderId;
        $obj->productId = $this->productId;
        $obj->quantity = $this->quantity;

        return $obj;
    }
}

?>