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

    public static function userLogin() {
        include 'view/userLogin.view.php';
    }

    public static function userSignup() {
        include 'view/userSignup.view.php';
    }

    public static function productList($products) {
        include 'view/productList.view.php';
    }

    public static function productDetail($product) {
        include 'view/productDetail.view.php';
    }

    public static function shoppingCart($shoppingCart) {
        include 'view/shoppingCart.view.php';
    }

    public static function showErrors($errors) {
        include 'view/showErrors.view.php';
    }
}

?>