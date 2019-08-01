<?php

class OrderController {
    private static $sortType = "";

    public static function getActionResult($action, $sortBy = "", $data = null) {
        self::$sortType = $sortBy;
        switch($action){
            case "view": 
                $jorder = RestClient::call("GET", ORDER_API, array("id" => $data));
                $order = OrderHead::deserialize($jorder);
                AdminPage::orderDetails($prod, "view");
            break;
            case "add":
                $no = new OrderHead();
                AdminPage::orderDetails($no, "add");
            break;
            case "edit":
                $jorder = RestClient::call("GET", ORDER_API, array("id" =>$data));
                $no = OrderHead::deserialize($jorder);
                AdminPage::orderDetails($no, "edit");
            break;
            case "delete":
            default:
                self::displayList();
            break;
        }
    }

    public static function postActionResult($postData) {
        $validation = self::validationData($postData);

        if(count($validation) == 0){
            // OrderHead have id it must be an update action
            if($postData['id'] != 0) {
                $result = RestClient::call("PUT", ORDER_API, $postData);
            } else { // otherwise, it is an insert action
                $result =  RestClient::call("POST", ORDER_API, $postData);
            }

            AdminPage::redirectToList("order");
        } else {
            $no = new OrderHead();
            // $np->setId($postData['id']);
            // $np->setName($postData['name']);
            // $np->setBrand($postData['brand']);
            // $np->setPrice($postData['price']);
            // $np->setImageUrl($postData['imageUrl']);
            AdminPage::orderDetails($no, "edit", $validation);
        }
    }

    private static function validationData($fromData){
        $errors = array();

        if(empty($fromData['name'])) {
            $errors[] = "Please enter order name";
        }
        if(empty($fromData['brand'])) {
            $errors[] = "Please enter order brand";
        }
        if(empty($fromData['price'])) {
            $errors[] = "Please enter order price";
        }

        return $errors;
    }

    private static function displayList(){
        $jorders = RestClient::call("GET", ORDER_API);
        $orders = array_map('OrderHead::deserialize', $jorders);
        usort($orders, "self::compareOrder");

        AdminPage::orderList($orders);
    }

    private static function compareOrder(OrderHead $o1, OrderHead $o2){
        if(self::$sortType != ""){
            switch(self::$sortType){   
                case "createDate" : return $o1->getCreateDate() <=> $o2->getCreateDate();
                default: return $o1->getId() <=> $o2->getId();
            }
        } else {
            return $o1->getId() <=> $o2->getId();
        }
    }
}

?>