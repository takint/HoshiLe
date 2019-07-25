<?php

require_once 'inc/config.inc.php';
require_once 'inc/Client/Page.class.php';
require_once 'inc/Entity/BaseEntity.class.php';
require_once 'inc/Entity/Product.class.php';
require_once 'inc/RestAPI/RestClient.class.php';

if (isset($_GET['productId'])) {
    $result = RestClient::call('GET', PRODUCT_API, array('id' => $_GET['productId']));
    $product = Product::deserialize($result);
} else {
    $result = RestClient::call('GET', PRODUCT_API);
    $products = array_map('Product::deserialize', $result);
}

ClientPage::header();
ClientPage::navigator();
if (isset($_GET['productId'])) {
    ClientPage::productDetail($product);
} else {
    ClientPage::productList($products);
}
ClientPage::footer();

?>