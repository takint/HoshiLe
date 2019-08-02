<?php

class ClientPage {

    public static $title = "HoshiLe’s Store";

    public static $errors = array();

    public static function header(string $extra = null) {
        if (!is_null($extra)) {
            self::$title .= ' - ' . $extra;
        }
        include 'view/head.view.php';
    }

    public static function navigator() {
        include 'view/nav.view.php';
    }

    public static function footer() {
        include 'view/footer.view.php';
    }

    public static function userLogin(bool $forPurchase) {
        self::header('Login');
        self::navigator();
        include 'view/userLogin.view.php';
        self::footer();
    }

    public static function userSignup(bool $forPurchase) {
        self::header('Signup');
        self::navigator();
        include 'view/userSignup.view.php';
        self::footer();
    }

    public static function userProfile(User $user) {
        self::header('Profile');
        self::navigator();
        include 'view/userProfile.view.php';
        self::footer();
    }

    public static function productList(array $products) {
        self::header();
        self::navigator();
        include 'view/productList.view.php';
        self::footer();
    }

    public static function productDetail(Product $product) {
        self::header(htmlspecialchars($product->getName()));
        self::navigator();
        include 'view/productDetail.view.php';
        self::footer();
    }

    public static function shoppingCart(array $shoppingCart) {
        self::header('Shopping Cart');
        self::navigator();
        include 'view/shoppingCart.view.php';
        self::footer();
    }

    public static function orderList(array $orders) {
        self::header('Order History');
        self::navigator();
        include 'view/orderList.view.php';
        self::footer();
    }

    public static function orderDetail(OrderHead $order) {
        self::header('Order Detail');
        self::navigator();
        include 'view/orderDetail.view.php';
        self::footer();
    }

    public static function showErrors(string $error = null) {
        if (!is_null($error)) {
            self::$errors[] = $error;
        }
        self::header('Error');
        self::navigator();
        include 'view/showErrors.view.php';
        self::footer();
    }

    public static function redirect(string $error = null, string $page = null) {
        if (is_null($error)) {
            header('Location: ' . $_SERVER['PHP_SELF'] . (is_null($page) ? '' : '?page=' . $page));
            exit;
        } else {
            self::$errors[] = $error;
        }
    }
}

?>