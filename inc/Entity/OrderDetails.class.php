<?php

// +-----------+---------+------+-----+---------+-------+
// | Field     | Type    | Null | Key | Default | Extra |
// +-----------+---------+------+-----+---------+-------+
// | orderId   | int(11) | NO   | PRI | NULL    |       |
// | detailId  | int(11) | NO   | PRI | NULL    |       |
// | productId | int(11) | NO   |     | NULL    |       |
// | quantity  | int(11) | NO   |     | NULL    |       |
// +-----------+---------+------+-----+---------+-------+

class OrderDetails {
    private $orderId  ;
    private $detailId ;
    private $productId;
    private $quantity ;

    // Getter
    public function getOrderId() : int {
        return $this->orderId;
    }

    public function getDetailId() : int {
        return $this->detailId;
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

    public function setDetailId(int $value) {
        $this->detailId = $value;
    }

    public function setProductId(int $value) {
        $this->productId = $value;
    }

    public function setQuantity(int $value) {
        $this->quantity = $value;
    }

    public function serialize() : stdClass {
        $obj = new stdClass;
        
        $obj->orderId = $this->orderId;
        $obj->detailId = $this->detailId;
        $obj->productId = $this->productId;
        $obj->quantity = $this->quantity;

        return $obj;
    }
}

?>