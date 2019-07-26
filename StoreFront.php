<?php

require_once 'inc/config.inc.php';
require_once 'inc/Client/Page.class.php';
require_once 'inc/Client/Session.class.php';
require_once 'inc/Entity/BaseEntity.class.php';
require_once 'inc/Entity/Product.class.php';
require_once 'inc/Entity/User.class.php';
require_once 'inc/RestAPI/RestClient.class.php';

Session::initialize();

$errors = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] == 'login' && isset($_POST['email']) && isset($_POST['password'])) {
        $params = array('email' => $_POST['email'], 'password' => $_POST['password']);
        $result = RestClient::call('GET', USER_API, $params);
        if ($result) {
            Session::setUser(User::deserialize($result));
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $errors[] = 'Oops, email or password is incorrect.';
        }
    }
    if ($_POST['action'] == 'logout') {
        Session::logout();
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
    if ($_POST['action'] == 'addToCart' && isset($_POST['productId'])) {
        Session::addProduct($_POST['productId']);
        header('Location: ' . $_SERVER['PHP_SELF'] . '?page=shoppingCart');
        exit;
    }
    if ($_POST['action'] == 'updateCart' && isset($_POST['productId']) && isset($_POST['quantity'])) {
        Session::updateCart($_POST['productId'], $_POST['quantity']);
        header('Location: ' . $_SERVER['PHP_SELF'] . '?page=shoppingCart');
        exit;
    }
    if (empty($errors)) {
        $errors[] = 'Sorry, something goes wrong.';
    }
}

ClientPage::header();
ClientPage::navigator();
if (!empty($errors)) {
    ClientPage::alert($errors);
} else if (isset($_GET['page']) && $_GET['page'] == 'login') {
    ClientPage::login();
} else if (isset($_GET['page']) && $_GET['page'] == 'signup') {
    ClientPage::signup();
} else if (isset($_GET['page']) && $_GET['page'] == 'shoppingCart') {
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
    if ($result) {
        $product = Product::deserialize($result);
        ClientPage::productDetail($product);
    } else {
        ClientPage::alert(array('Sorry, product not found.'));
    }
} else {
    $result = RestClient::call('GET', PRODUCT_API);
    $products = array_map('Product::deserialize', $result);
    ClientPage::productList($products);
}
ClientPage::footer();

?>