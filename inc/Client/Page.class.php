<?php

class ClientPage {

    public static $title = "HoshiLe’s Store";

    public static function header() {
        include 'view/head.view.php';
    }

    public static function navigator() {
        include 'view/nav.view.php';
    }

    public static function footer() {
        include 'view/footer.view.php';
    }

    public static function userLogin(bool $forPurchase) {
        include 'view/userLogin.view.php';
    }

    public static function userSignup(bool $forPurchase) {
        include 'view/userSignup.view.php';
    }

    public static function userProfile(User $user) {
        include 'view/userProfile.view.php';
    }

    public static function productList(array $products) {
        include 'view/productList.view.php';
    }

    public static function productDetail(Product $product) {
        include 'view/productDetail.view.php';
    }

    public static function shoppingCart(array $shoppingCart) {
        include 'view/shoppingCart.view.php';
    }

    public static function orderDetail(OrderHead $order) {
        include 'view/orderDetail.view.php';
    }

    public static function showErrors(array $errors) {
        include 'view/showErrors.view.php';
    }
}

?>