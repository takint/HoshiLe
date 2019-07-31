<?php

require_once('inc/config.inc.php');
require_once('inc/Entity/BaseEntity.class.php');
require_once('inc/Entity/OrderHead.class.php');
require_once('inc/RestAPI/PDOAgent.class.php');
require_once('inc/RestAPI/OrderHeadDAO.class.php');

//Instantiate a new Order Mappers
OrderHeadDAO::initialize();

//Pull the request data
$requestData = json_decode(file_get_contents('php://input'));

//Do something based on the request
switch ($_SERVER['REQUEST_METHOD']) {

    //If there was a request with an id return that order, if not return all of them!
    case 'GET':
        if (isset($requestData->id)) {
            $order = OrderHeadDAO::getOrderHead($requestData->id);
            $stdOrder = is_null($order) ? null : $order->serialize();

            header('Content-Type: application/json');
            echo json_encode($stdOrder);
        } else {
            $orders = OrderHeadDAO::getOrderHeads();
            $stdOrders = array();
            foreach ($orders as $order) {
                $stdOrders[] = $order->serialize();
            }

            header('Content-Type: application/json');
            echo json_encode($stdOrders);
        }
        break;

    case 'POST':
        if (!empty($requestData)) {
            $np = OrderHead::deserialize($requestData);
            $result = OrderHeadDAO::createOrderHead($np);

            header('Content-Type: application/json');
            echo json_encode($result);
        }
        break;

    default:
        echo json_encode(array('message' => 'Você fala HTTP?'));
        break;
}

?>