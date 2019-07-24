<?php

require_once 'inc/config.inc.php';
require_once 'inc/Client/Page.class.php';
require_once 'inc/Entity/BaseEntity.class.php';
require_once 'inc/Entity/Product.class.php';
require_once 'inc/RestAPI/RestClient.class.php';

$result = RestClient::call('GET', PRODUCT_API);
$products = array_map('Product::deserialize', $result);

ClientPage::header();
ClientPage::navigator();
ClientPage::productList($products);
ClientPage::footer();

?>