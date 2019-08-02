<?php

require_once 'inc/config.inc.php';
require_once 'inc/Client/Page.class.php';
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

$errors = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['action'] ?? '') {
        case 'login':
            $error = Session::login($_POST['email'] ?? '', $_POST['password'] ?? '');
            if (is_null($error)) {
                if (isset($_POST['forPurchase']) && $_POST['forPurchase'] == 'true') {
                    header('Location: ' . $_SERVER['PHP_SELF'] . '?page=shoppingCart');
                } else {
                    header('Location: ' . $_SERVER['PHP_SELF']);
                }
                exit;
            } else {
                $errors[] = $error;
            }
            break;

        case 'signup':
            $error = Session::signup($_POST['name'] ?? '', $_POST['email'] ?? '', $_POST['password1'] ?? '', $_POST['password2'] ?? '');
            if (is_null($error)) {
                if (isset($_POST['forPurchase']) && $_POST['forPurchase'] == 'true') {
                    header('Location: ' . $_SERVER['PHP_SELF'] . '?page=shoppingCart');
                } else {
                    header('Location: ' . $_SERVER['PHP_SELF']);
                }
                exit;
            } else {
                $errors[] = $error;
            }
            break;

        case 'updateProfile':
            $error = Session::updateProfile($_POST['name'] ?? '', $_POST['email'] ?? '');
            if (is_null($error)) {
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } else {
                $errors[] = $error;
            }
            break;

        case 'updatePassword':
            $error = Session::updatePassword($_POST['curPassword'] ?? '', $_POST['password1'] ?? '', $_POST['password2'] ?? '');
            if (is_null($error)) {
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } else {
                $errors[] = $error;
            }
            break;

        case 'logout':
            Session::logout();
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;

        case 'addToCart':
            if (isset($_POST['productId'])) {
                ShoppingCart::addProduct($_POST['productId']);
                header('Location: ' . $_SERVER['PHP_SELF'] . '?page=shoppingCart');
                exit;
            }
            break;

        case 'updateQuantity':
            if (isset($_POST['productId']) && isset($_POST['quantity'])) {
                ShoppingCart::updateQuantity($_POST['productId'], $_POST['quantity']);
                header('Location: ' . $_SERVER['PHP_SELF'] . '?page=shoppingCart');
                exit;
            }
            break;

        case 'purchase':
            $result = ShoppingCart::purchase();
            if (is_int($result)) {
                header('Location: ' . $_SERVER['PHP_SELF'] . '?orderId=' . $result);
                exit;
            } else {
                $errors[] = $result;
            }
            break;
    }

    if (empty($errors)) {
        $errors[] = 'Sorry, something goes wrong.';
    }
}

ClientPage::header();
ClientPage::navigator();
if (!empty($errors)) {
    ClientPage::showErrors($errors);
} else if (isset($_GET['page']) && $_GET['page'] == 'login') {
    ClientPage::userLogin(isset($_GET['forPurchase']) && $_GET['forPurchase'] == 'true');
} else if (isset($_GET['page']) && $_GET['page'] == 'signup') {
    ClientPage::userSignup(isset($_GET['forPurchase']) && $_GET['forPurchase'] == 'true');
} else if (isset($_GET['page']) && $_GET['page'] == 'profile') {
    $result = RestClient::call('GET', USER_API, array('id' => Session::$userId));
    if ($result) {
        $user = User::deserialize($result);
        Session::setUser($user->getId(), $user->getName());
        ClientPage::userProfile($user);
    } else {
        ClientPage::showErrors(array('Sorry, user not found.'));
    }
} else if (isset($_GET['page']) && $_GET['page'] == 'shoppingCart') {
    $ids = array_map(function($tuple) { return $tuple->productId; }, ShoppingCart::$shoppingCart);
    if (!empty($ids)) {
        $result = RestClient::call('GET', PRODUCT_API, array('ids' => $ids));
        $products = array_map('Product::deserialize', $result);
    } else {
        $products = array();
    }
    ClientPage::shoppingCart(ShoppingCart::getShoppingCart($products));
} else if (isset($_GET['page']) && $_GET['page'] == 'orderList') {
    $result = RestClient::call('GET', ORDER_API, array('userId' => Session::$userId));
    if ($result) {
        $orders = array_map('OrderHead::deserialize', $result);
        ClientPage::orderList($orders);
    } else {
        ClientPage::showErrors(array('Sorry, order not found.'));
    }
} else if (isset($_GET['orderId'])) {
    $result = RestClient::call('GET', ORDER_API, array('id' => $_GET['orderId']));
    if ($result) {
        $order = OrderHead::deserialize($result);
        ClientPage::orderDetail($order);
    } else {
        ClientPage::showErrors(array('Sorry, order not found.'));
    }
} else if (isset($_GET['productId'])) {
    $result = RestClient::call('GET', PRODUCT_API, array('id' => $_GET['productId']));
    if ($result) {
        $product = Product::deserialize($result);
        ClientPage::productDetail($product);
    } else {
        ClientPage::showErrors(array('Sorry, product not found.'));
    }
} else {
    $result = RestClient::call('GET', PRODUCT_API);
    $products = array_map('Product::deserialize', $result);
    ClientPage::productList($products);
}
ClientPage::footer();

?>