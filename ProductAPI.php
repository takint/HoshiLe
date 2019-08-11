<?php

require_once('inc/config.inc.php');
require_once('inc/Entity/BaseEntity.class.php');
require_once('inc/Entity/Product.class.php');
require_once('inc/RestAPI/PDOAgent.class.php');
require_once('inc/RestAPI/ProductDAO.class.php');

//Instantiate a new Product Mapper
ProductDAO::initialize();

//Pull the request data
$requestData = json_decode(file_get_contents('php://input'));
if (is_null($requestData) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $requestData = new stdClass();
    if (isset($_GET['id'])) {
        $requestData->id = $_GET['id'];
    }
    if (isset($_GET['ids'])) {
        $requestData->ids = array_map('intval', explode(',', $_GET['ids']));
    }
}

//Do something based on the request
switch ($_SERVER['REQUEST_METHOD']) {

    //If there was a request with an id return that product, if not return all of them!
    case 'GET':
        if (isset($requestData->id)) {
            $product = ProductDAO::getProduct($requestData->id);
            $stdProduct = is_null($product) ? null : $product->serialize();

            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode($stdProduct);
        } else {
            if (isset($requestData->ids)) {
                $products = ProductDAO::getProducts(array_filter($requestData->ids, 'is_int'));
            } else {
                $products = ProductDAO::getProducts();
            }
            $stdProducts = array();
            foreach ($products as $product) {
                $stdProducts[] = $product->serialize();
            }

            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode($stdProducts);
        }
    break;
    case 'POST': 
        if(!empty($requestData)){
            $np = Product::deserialize($requestData);
            $result = ProductDAO::createProduct($np);

            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode($result);
        }
    break;
    case 'PUT': 
        if(!empty($requestData)){
            $np = Product::deserialize($requestData);
            $result = ProductDAO::updateProduct($np);

            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode($result);
        }
    break;
    case 'DELETE': 
        if (isset($requestData->id)) {
            $result = ProductDAO::deleteProduct($requestData->id);

            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode($result);
        }
    break;
    case 'OPTIONS':
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Access-Control-Max-Age: 86400');
    break;
    default:
        echo json_encode(array('message' => 'Você fala HTTP?'));
        break;
}

?>