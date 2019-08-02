<?php

class ShoppingCart {

    public static $shoppingCart = array();

    public static function initialize() {
        if (!empty($_SESSION['shoppingCart'])) {
            self::$shoppingCart = json_decode($_SESSION['shoppingCart']);
        }
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
        self::incrementProduct($productId, 1);
        self::updateShoppingCart();
    }

    public static function updateQuantity(int $productId, int $quantity) {
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
        self::updateShoppingCart();
    }

    public static function mergeShoppingCart(array $savedCart = null) {
        if (is_array($savedCart)) {
            foreach ($savedCart as $tuple) {
                if (isset($tuple->productId) && isset($tuple->quantity)) {
                    self::incrementProduct($tuple->productId, $tuple->quantity);
                }
            }
        }
        self::updateShoppingCart();
    }

    public static function clearShoppingCart() {
        self::$shoppingCart = array();
        self::updateShoppingCart();
    }

    private static function incrementProduct(int $productId, int $incr) {
        $found = false;
        foreach (self::$shoppingCart as $tuple) {
            if ($tuple->productId == $productId) {
                $tuple->quantity += $incr;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $tuple = new stdClass();
            $tuple->productId = $productId;
            $tuple->quantity = $incr;
            self::$shoppingCart[] = $tuple;
        }
    }

    private static function updateShoppingCart() {
        $encodedCart = json_encode(self::$shoppingCart);
        $_SESSION['shoppingCart'] = $encodedCart;

        if (!is_null(Session::$userId)) {
            $params = array(
                'id' => Session::$userId,
                'shoppingCart' => $encodedCart
            );
            $result = RestClient::call('PUT', USER_API, $params);
        }
    }
}

?>