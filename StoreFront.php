<?php

require_once 'inc/config.inc.php';
require_once 'inc/Client/Page.class.php';
require_once 'inc/Client/Session.class.php';
require_once 'inc/Entity/BaseEntity.class.php';
require_once 'inc/Entity/Product.class.php';
require_once 'inc/RestAPI/RestClient.class.php';

Session::initialize();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] == 'addToCart' && isset($_POST['productId'])) {
        Session::addProduct($_POST['productId']);
        header('Location: ' . $_SERVER['PHP_SELF'] . '?mode=shoppingCart');
        exit;
    }
    if ($_POST['action'] == 'updateCart' && isset($_POST['productId']) && isset($_POST['quantity'])) {
        Session::updateCart($_POST['productId'], $_POST['quantity']);
        header('Location: ' . $_SERVER['PHP_SELF'] . '?mode=shoppingCart');
        exit;
    }
}

ClientPage::header();
ClientPage::navigator();
if (isset($_GET['mode']) && $_GET['mode'] == 'shoppingCart') {
    $ids = array_map(function($tuple) { return $tuple->productId; }, Session::$shoppingCart);
    if (!empty($ids)) {
        $result = RestClient::call('GET', PRODUCT_API, array('ids' => $ids));
        $products = array_map('Product::deserialize', $result);
    } else {
        $products = array();
    }
    ClientPage::shoppingCart(Session::getShoppingCart($products));
} else if (isset($_GET['productId'])) {
    $result = RestClient::call('GET', PRODUCT_API, array('id' => $_GET['productId']));
    $product = Product::deserialize($result);
    ClientPage::productDetail($product);
} else {
    $result = RestClient::call('GET', PRODUCT_API);
    $products = array_map('Product::deserialize', $result);
    ClientPage::productList($products);
}
ClientPage::footer();

?>