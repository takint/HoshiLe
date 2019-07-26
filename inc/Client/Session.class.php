<?php

class Session {

    public static $userId = null;
    public static $userName = null;

    public static $shoppingCart = array();

    public static function initialize() {
        session_start();

        if (!empty($_SESSION['user'])) {
            self::$userId = $_SESSION['user']['id'];
            self::$userName = $_SESSION['user']['name'];
        }

        if (!empty($_SESSION['shoppingCart'])) {
            self::$shoppingCart = json_decode($_SESSION['shoppingCart']);
        }
    }

    public static function setUser(int $id, string $name) {
        self::$userId = $id;
        self::$userName = $name;
        $_SESSION['user'] = array(
            'id' => self::$userId,
            'name' => self::$userName
        );
    }

    public static function logout() {
        self::$userId = null;
        self::$userName = null;
        unset($_SESSION['user']);
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

    public static function updateCart(int $productId, int $quantity) {
        foreach (self::$shoppingCart as $key => $tuple) {
            if ($tuple->productId == $productId) {
                if ($quantity > 0) {
                    $tuple->quantity = $quantity;
                } else {
                    unset(self::$shoppingCart[$key]);
                    self::$shoppingCart = array_values(self::$shoppingCart);
                }
                break;
            }
        }
        $_SESSION['shoppingCart'] = json_encode(self::$shoppingCart);
    }
}

?>