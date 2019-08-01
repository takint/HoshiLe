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
        $params = array(
            'email' => $_POST['email'],
            'password' => $_POST['password']
        );
        $result = RestClient::call('GET', USER_API, $params);
        if ($result) {
            $user = User::deserialize($result);
            Session::setUser($user->getId(), $user->getName());
            Session::mergeShoppingCart(json_decode($user->getShoppingCart()));
            if (isset($_POST['forPurchase']) && $_POST['forPurchase'] == 'true') {
                header('Location: ' . $_SERVER['PHP_SELF'] . '?page=shoppingCart');
            } else {
                header('Location: ' . $_SERVER['PHP_SELF']);
            }
            exit;
        } else {
            $errors[] = 'Oops, email or password is incorrect.';
        }
    }
    if ($_POST['action'] == 'signup' && isset($_POST['name']) &&
            isset($_POST['email']) && isset($_POST['password1']) && isset($_POST['password2'])) {
        if ($_POST['name'] == '' || $_POST['email'] == '' || $_POST['password1'] == '') {
            $errors[] = 'Oops, your name, email, or password is empty.';
        } else if ($_POST['password1'] != $_POST['password2']) {
            $errors[] = 'Oops, your passwords do not match.';
        } else {
            $params = array(
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password1']
            );
            $result = RestClient::call('POST', USER_API, $params);
            if ($result) {
                Session::setUser($result, $_POST['name']);
                Session::mergeShoppingCart();
                if (isset($_POST['forPurchase']) && $_POST['forPurchase'] == 'true') {
                    header('Location: ' . $_SERVER['PHP_SELF'] . '?page=shoppingCart');
                } else {
                    header('Location: ' . $_SERVER['PHP_SELF']);
                }
                exit;
            } else {
                $errors[] = 'Sorry, failed to create a user.';
            }
        }
    }
    if ($_POST['action'] == 'updateProfile' && !is_null(Session::$userId)
            && isset($_POST['name']) && isset($_POST['email'])) {
        if ($_POST['name'] == '' || $_POST['email'] == '') {
            $errors[] = 'Oops, your name or email is empty.';
        } else {
            $params = array(
                'id' => Session::$userId,
                'name' => $_POST['name'],
                'email' => $_POST['email']
            );
            $result = RestClient::call('PUT', USER_API, $params);
            if ($result) {
                Session::setUser(Session::$userId, $_POST['name']);
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } else {
                $errors[] = 'Sorry, failed to update a user.';
            }
        }
    }
    if ($_POST['action'] == 'updatePassword' && !is_null(Session::$userId)
            && isset($_POST['curPassword']) && isset($_POST['password1']) && isset($_POST['password2'])) {
        if ($_POST['curPassword'] == '' || $_POST['password1'] == '') {
            $errors[] = 'Oops, your password is empty.';
        } else if ($_POST['password1'] != $_POST['password2']) {
            $errors[] = 'Oops, your passwords do not match.';
        } else {
            $params = array(
                'id' => Session::$userId,
                'curPassword' => $_POST['curPassword'],
                'newPassword' => $_POST['password1']
            );
            $result = RestClient::call('PUT', USER_API, $params);
            if ($result) {
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } else {
                $errors[] = 'Sorry, failed to update password.';
            }
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
    if ($_POST['action'] == 'updateQuantity' && isset($_POST['productId']) && isset($_POST['quantity'])) {
        Session::updateQuantity($_POST['productId'], $_POST['quantity']);
        header('Location: ' . $_SERVER['PHP_SELF'] . '?page=shoppingCart');
        exit;
    }
    if ($_POST['action'] == 'purchase' && !is_null(Session::$userId) && !empty(Session::$shoppingCart)) {
        $params = array(
            'userId' => Session::$userId,
            'details' => Session::$shoppingCart
        );
        $result = RestClient::call('POST', ORDER_API, $params);
        if ($result) {
            Session::clearShoppingCart();
            header('Location: ' . $_SERVER['PHP_SELF'] . '?orderId=' . $result);
            exit;
        } else {
            $errors[] = 'Sorry, failed to purchase.';
        }
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
    $ids = array_map(function($tuple) { return $tuple->productId; }, Session::$shoppingCart);
    if (!empty($ids)) {
        $result = RestClient::call('GET', PRODUCT_API, array('ids' => $ids));
        $products = array_map('Product::deserialize', $result);
    } else {
        $products = array();
    }
    ClientPage::shoppingCart(Session::getShoppingCart($products));
} else if (isset($_GET['orderId'])) {
    ClientPage::showErrors(array('Purchase completed.'));
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