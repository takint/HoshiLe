<?php

require_once('inc/config.inc.php');
require_once('inc/Entity/BaseEntity.class.php');
require_once('inc/Entity/OrderHead.class.php');
require_once('inc/Entity/OrderDetail.class.php');
require_once('inc/Entity/Product.class.php');
require_once('inc/Entity/User.class.php');
require_once('inc/RestAPI/PDOAgent.class.php');
require_once('inc/RestAPI/OrderHeadDAO.class.php');
require_once('inc/RestAPI/OrderDetailDAO.class.php');
require_once('inc/RestAPI/ProductDAO.class.php');
require_once('inc/RestAPI/UserDAO.class.php');

//Instantiate Order-related mappers
OrderHeadDAO::initialize();
OrderDetailDAO::initialize();
ProductDAO::initialize();
UserDAO::initialize();

//Pull the request data
$requestData = json_decode(file_get_contents('php://input'));
if (is_null($requestData) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $requestData = new stdClass();
    if (isset($_GET['id'])) {
        $requestData->id = $_GET['id'];
    }
    if (isset($_GET['userId'])) {
        $requestData->userId = $_GET['userId'];
    }
}

//Do something based on the request
switch ($_SERVER['REQUEST_METHOD']) {

    //If there was a request with an id return that order, if not return all of them!
    case 'GET':
        if (isset($requestData->id)) {
            $order = OrderHeadDAO::getOrderHead($requestData->id);
            if (!is_null($order)) {
                loadDetails($order);
                $stdOrder = $order->serialize();
            } else {
                $stdOrder = null;
            }

            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode($stdOrder);
        } else {
            if (isset($requestData->userId)) {
                $orders = OrderHeadDAO::getOrderHeads($requestData->userId);
            } else {
                $orders = OrderHeadDAO::getOrderHeads();
            }
            $stdOrders = array();
            foreach ($orders as $order) {
                loadDetails($order);
                $stdOrders[] = $order->serialize();
            }

            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode($stdOrders);
        }
        break;

    case 'POST':
        if (isset($requestData->userId) && !empty($requestData->details)) {
            $orderHead = new OrderHead();
            $orderHead->setUserId($requestData->userId);
            $orderId = OrderHeadDAO::createOrderHead($orderHead);
            foreach ($requestData->details as $detail) {
                $orderDetail = new OrderDetail();
                $orderDetail->setOrderId($orderId);
                $orderDetail->setProductId($detail->productId);
                $orderDetail->setQuantity($detail->quantity);
                OrderDetailDAO::createOrderDetail($orderDetail);
            }

            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode($orderId);
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

function loadDetails(OrderHead $order) {
    $order->setUser(UserDAO::getUser($order->getUserId()));
    $order->setDetails(OrderDetailDAO::getOrderDetails($order->getId()));
    foreach ($order->getDetails() as $detail) {
        $detail->setProduct(ProductDAO::getProduct($detail->getProductId()));
    }
}

?>