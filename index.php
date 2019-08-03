<?php

require_once 'inc/config.inc.php';
require_once 'inc/Client/ClientPage.class.php';
require_once 'inc/Client/Session.class.php';
require_once 'inc/Client/ShoppingCart.class.php';
require_once 'inc/Entity/BaseEntity.class.php';
require_once 'inc/Entity/Product.class.php';
require_once 'inc/Entity/User.class.php';
require_once 'inc/Entity/OrderHead.class.php';
require_once 'inc/Entity/OrderDetail.class.php';
require_once 'inc/RestAPI/RestClient.class.php';

Session::initialize();
ShoppingCart::initialize();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['action'] ?? '') {
        case 'login':
            $error = Session::login($_POST['email'] ?? '', $_POST['password'] ?? '');
            ClientPage::redirect($error, ($_POST['forPurchase'] ?? '') == 'true' ? 'shoppingCart' : null);
            break;

        case 'signup':
            $error = Session::signup($_POST['name'] ?? '', $_POST['email'] ?? '', $_POST['password1'] ?? '', $_POST['password2'] ?? '');
            ClientPage::redirect($error, ($_POST['forPurchase'] ?? '') == 'true' ? 'shoppingCart' : null);
            break;

        case 'updateProfile':
            $error = Session::updateProfile($_POST['name'] ?? '', $_POST['email'] ?? '');
            ClientPage::redirect($error);
            break;

        case 'updatePassword':
            $error = Session::updatePassword($_POST['curPassword'] ?? '', $_POST['password1'] ?? '', $_POST['password2'] ?? '');
            ClientPage::redirect($error);
            break;

        case 'logout':
            Session::logout();
            ClientPage::redirect();
            break;

        case 'addToCart':
            if (isset($_POST['productId'])) {
                ShoppingCart::addProduct($_POST['productId']);
                ClientPage::redirect(null, 'shoppingCart');
            }
            break;

        case 'updateQuantity':
            if (isset($_POST['productId']) && isset($_POST['quantity'])) {
                ShoppingCart::updateQuantity($_POST['productId'], $_POST['quantity']);
                ClientPage::redirect(null, 'shoppingCart');
            }
            break;

        case 'purchase':
            $result = ShoppingCart::purchase();
            if (is_int($result)) {
                header('Location: ' . $_SERVER['PHP_SELF'] . '?orderId=' . $result);
                exit;
            } else {
                ClientPage::$errors[] = $result;
            }
            break;
    }

    if (empty(ClientPage::$errors)) {
        ClientPage::$errors[] = 'Oops, something goes wrong.';
    }
    ClientPage::showErrors();
    exit;
}

if (isset($_GET['page'])) {
    switch ($_GET['page']) {
        case 'about':
            ClientPage::about();
            break;

        case 'login':
            ClientPage::userLogin(($_GET['forPurchase'] ?? '') == 'true');
            break;

        case 'signup':
            ClientPage::userSignup(($_GET['forPurchase'] ?? '') == 'true');
            break;

        case 'profile':
            if (is_null(Session::$userId)) {
                ClientPage::showErrors('Oops, you are not logged in');
                break;
            }
            $result = RestClient::call('GET', USER_API, array('id' => Session::$userId));
            if ($result) {
                $user = User::deserialize($result);
                Session::setUser($user->getId(), $user->getName());
                ClientPage::userProfile($user);
            } else {
                ClientPage::showErrors('Sorry, user not found.');
            }
            break;

        case 'shoppingCart':
            $ids = array_map(function($tuple) { return $tuple->productId; }, ShoppingCart::$shoppingCart);
            if (!empty($ids)) {
                $result = RestClient::call('GET', PRODUCT_API, array('ids' => $ids));
                $products = array_map('Product::deserialize', $result);
            } else {
                $products = array();
            }
            ClientPage::shoppingCart(ShoppingCart::getShoppingCart($products));
            break;

        case 'orderList':
            if (is_null(Session::$userId)) {
                ClientPage::showErrors('Oops, you are not logged in');
                break;
            }
            $result = RestClient::call('GET', ORDER_API, array('userId' => Session::$userId));
            if ($result) {
                $orders = array_map('OrderHead::deserialize', $result);
                ClientPage::orderList($orders);
            } else {
                ClientPage::showErrors('Sorry, failed to get order list.');
            }
            break;

        default:
            ClientPage::showErrors('Oops, something goes wrong.');
            break;
    }
} else {
    switch (true) {
        case isset($_GET['orderId']):
            if (is_null(Session::$userId)) {
                ClientPage::showErrors('Oops, you are not logged in');
                break;
            }
            $result = RestClient::call('GET', ORDER_API, array('id' => $_GET['orderId']));
            if ($result) {
                $order = OrderHead::deserialize($result);
                ClientPage::orderDetail($order);
            } else {
                ClientPage::showErrors('Sorry, order not found.');
            }
            break;

        case isset($_GET['productId']):
            $result = RestClient::call('GET', PRODUCT_API, array('id' => $_GET['productId']));
            if ($result) {
                $product = Product::deserialize($result);
                ClientPage::productDetail($product);
            } else {
                ClientPage::showErrors('Sorry, product not found.');
            }
            break;

        default:
            $result = RestClient::call('GET', PRODUCT_API);
            if ($result) {
                $products = array_map('Product::deserialize', $result);
                ClientPage::productList($products);
            } else {
                ClientPage::showErrors('Sorry, failed to get product list.');
            }
            break;
    }
}

?>