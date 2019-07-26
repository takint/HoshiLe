<?php

class Session {

    private static $shoppingCart = array();

    public static function initialize() {
        session_start();

        if (!empty($_SESSION['shoppingCart'])) {
            self::$shoppingCart = json_decode($_SESSION['shoppingCart']);
        }
    }

    public static function addProduct(int $productId) {
        $found = false;
        foreach (self::$shoppingCart as $tuple) {
            if ($tuple->productId == $productId) {
                $tuple->quantity++;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $tuple = new stdClass();
            $tuple->productId = $productId;
            $tuple->quantity = 1;
            self::$shoppingCart[] = $tuple;
        }
        $_SESSION['shoppingCart'] = json_encode(self::$shoppingCart);
    }

    public static function getShoppingCart(array $products): array {
        $result = array();
        foreach (self::$shoppingCart as $tuple) {
            $product = null;
            foreach ($products as $p) {
                if ($p->getId() == $tuple->productId) {
                    $product = $p;
                    break;
                }
            }
            if ($product) {
                $t = new stdClass();
                $t->product = $product;
                $t->quantity = $tuple->quantity;
                $result[] = $t;
            }
        }
        return $result;
    }
}

?>