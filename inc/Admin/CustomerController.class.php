<?php

class CustomerController {
    private static $sortType = "";

    public static function getActionResult($action, $sortBy = "", $data = null) {
        self::$sortType = $sortBy;
        switch($action){
            case "view": 
                $jcustomer = RestClient::call("GET", USER_API, array("id" => $data));
                $cust = User::deserialize($jcustomer);
                AdminPage::customerDetails($cust, "view");
            break;
            case "add":
                $nc = new User();
                AdminPage::customerDetails($nc, "add");
            break;
            case "edit":
                $jcustomer = RestClient::call("GET", USER_API, array("id" => $data));
                $cust = User::deserialize($jcustomer);
                AdminPage::customerDetails($cust, "edit");
            break;
            case "delete":
                $isDeleted = RestClient::call("DELETE", USER_API, array("id" => $data));
                if($isDeleted){
                   self::displayList($sortBy);
                }
            break;
            default:
                self::displayList($sortBy);
            break;
        }
    }

    public static function postActionResult($postData) {
        $validation = self::validationData($postData);

        if(count($validation) == 0){
            // Product have id it must be an update action
            if($postData['id'] != 0) {
                $result = RestClient::call("PUT", USER_API, $postData);
            } else { // otherwise, it is an insert action
                $result =  RestClient::call("POST", USER_API, $postData);
            }

            AdminPage::redirectToList("customer");
        } else {
            $np = new User();
            // $np->setId($postData['id']);
            // $np->setName($postData['name']);
            // $np->setBrand($postData['brand']);
            // $np->setPrice($postData['price']);
            // $np->setImageUrl($postData['imageUrl']);
            // AdminPage::customerDetails($np, "edit", $validation);
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
        $jcustomers = RestClient::call("GET", USER_API);
        $customers = array_map('User::deserialize', $jcustomers);
        usort($customers, "self::compareUser");

        AdminPage::customerList($customers);
    }

    private static function compareProduct(User $p1, User $p2){
        if(self::$sortType != ""){
            switch(self::$sortType){   
                case "name" : return $p1->getName() <=> $p2->getName();
                case "brand": return $p1->getBrand() <=> $p2->getBrand();
                case "price": return $p1->getPrice() <=> $p2->getPrice();
                default: return $p1->getId() <=> $p2->getId();
            }
        } else {
            return $p1->getId() <=> $p2->getId();
        }
    }
}

?>