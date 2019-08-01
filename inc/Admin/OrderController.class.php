<?php

class OrderController {
    private static $sortType = "";

    public static function getActionResult($action, $sortBy = "", $data = null) {
        self::$sortType = $sortBy;
        switch($action){
            case "view": 
                $jproduct = RestClient::call("GET", ORDER_API, array("id" => $data));
                $prod = Product::deserialize($jproduct);
                AdminPage::productDetails($prod, "view");
            break;
            case "add":
                $np = new Product();
                AdminPage::productDetails($np, "add");
            break;
            case "edit":
                $jproduct = RestClient::call("GET", ORDER_API, array("id" =>$data));
                $prod = Product::deserialize($jproduct);
                AdminPage::productDetails($prod, "edit");
            break;
            case "delete":
                $isDeleted = RestClient::call("DELETE", ORDER_API, array("id" =>$data));
                if($isDeleted){
                   self::displayList();
                }
            break;
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
            $np = new OrderHead();
            $np->setId($postData['id']);
            $np->setName($postData['name']);
            $np->setBrand($postData['brand']);
            $np->setPrice($postData['price']);
            $np->setImageUrl($postData['imageUrl']);
            AdminPage::productDetails($np, "edit", $validation);
        }
    }

    private static function validationData($fromData){
        $errors = array();

        if(empty($fromData['name'])) {
            $errors[] = "Please enter product name";
        }
        if(empty($fromData['brand'])) {
            $errors[] = "Please enter product brand";
        }
        if(empty($fromData['price'])) {
            $errors[] = "Please enter product price";
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