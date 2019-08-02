<?php

class Session {

    public static $userId = null;
    public static $userName = null;

    public static function initialize() {
        session_start();

        if (!empty($_SESSION['user'])) {
            self::$userId = $_SESSION['user']['id'];
            self::$userName = $_SESSION['user']['name'];
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

        ShoppingCart::clearShoppingCart();
    }
}

?>